<?php

namespace App\Livewire\Dashboard;

use App\Models\Carrier;
use App\Models\CarrierUsage;
use App\Models\Customer;
use App\Models\RevenueSummary;
use App\Services\CarrierCostAllocationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Financial extends Component
{
    public $mes;
    public $ano;

    public function mount()
    {
        $this->mes = now()->month;
        $this->ano = now()->year;
    }

    /**
     * Limpa filtros e volta ao padrão
     */
    public function clearFilters()
    {
        $this->mes = now()->month;
        $this->ano = now()->year;
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        $periodo = "{$this->ano}-{$this->mes}";

        // Limpa todos os caches do dashboard financeiro
        Cache::forget("financial:metrics:{$periodo}");
        Cache::forget("financial:evolucao:{$periodo}");
        Cache::forget("financial:top_clientes:{$periodo}");
        Cache::forget("financial:distribuicao:{$periodo}");
        Cache::forget("financial:custos_operadora:{$periodo}");
        Cache::forget("financial:total_clientes");
        Cache::forget("financial:comparacao:{$periodo}");

        // Força re-renderização
        $this->render();
    }

    /**
     * Exporta relatório para Excel
     */
    public function exportExcel()
    {
        // TODO: Implementar exportação Excel
        session()->flash('message', 'Exportação Excel em desenvolvimento');
    }

    /**
     * Exporta relatório para PDF
     */
    public function exportPdf()
    {
        // TODO: Implementar exportação PDF
        session()->flash('message', 'Exportação PDF em desenvolvimento');
    }

    public function render()
    {
        $periodo = "{$this->ano}-{$this->mes}";

        // Total de clientes ativos (cache de 30 minutos - muda raramente)
        $totalClientes = Cache::remember("financial:total_clientes", now()->addMinutes(30), function () {
            return Customer::where('ativo', true)->count();
        });

        // Métricas principais (cache de 10 minutos)
        $metrics = Cache::remember("financial:metrics:{$periodo}", now()->addMinutes(10), function () {
            // Receita total (chamadas + produtos) em uma única query
            $receitas = RevenueSummary::where('mes', $this->mes)
                ->where('ano', $this->ano)
                ->selectRaw('
                    SUM(custo_total) as receita_chamadas,
                    SUM(produtos_receita) as receita_produtos
                ')
                ->first();

            $receitaChamadas = $receitas->receita_chamadas ?? 0;
            $receitaProdutos = $receitas->receita_produtos ?? 0;
            $receita = $receitaChamadas + $receitaProdutos;

            return [
                'receita_chamadas' => $receitaChamadas,
                'receita_produtos' => $receitaProdutos,
                'receita' => $receita,
            ];
        });

        $receitaChamadas = $metrics['receita_chamadas'];
        $receitaProdutos = $metrics['receita_produtos'];
        $receita = $metrics['receita'];

        // Custos por operadora (cache de 10 minutos)
        // OTIMIZADO: Usa batch processing para reduzir queries
        $custosData = Cache::remember("financial:custos_operadora:{$periodo}", now()->addMinutes(10), function () {
            $costService = new CarrierCostAllocationService();

            // Busca IDs de todas carriers ativas
            $carrierIds = Carrier::where('ativo', true)->pluck('id')->toArray();

            if (empty($carrierIds)) {
                return [
                    'custo_total' => 0,
                    'custos_detalhados' => [],
                ];
            }

            // BATCH PROCESSING: Calcula custos de TODAS operadoras em 3 queries
            // Antes: 5 queries × N carriers = 25+ queries
            // Depois: 3 queries fixas
            $custosDetalhados = $costService->calcularCustoRealMultiplos($carrierIds, $this->mes, $this->ano);

            // Soma total
            $custo = collect($custosDetalhados)->sum('custo_total');

            return [
                'custo_total' => $custo,
                'custos_detalhados' => $custosDetalhados,
            ];
        });

        $custo = $custosData['custo_total'];
        $custosDetalhados = $custosData['custos_detalhados'];

        // Lucro
        $lucro = $receita - $custo;

        // Margem de lucro (%)
        $margemLucro = $receita > 0 ? ($lucro / $receita) * 100 : 0;

        // Ticket médio por cliente
        $ticketMedio = $totalClientes > 0 ? $receita / $totalClientes : 0;

        // Evolução dos últimos 6 meses (cache de 15 minutos)
        // OTIMIZADO: Usa batch processing para todos os meses
        $evolucao = Cache::remember("financial:evolucao:{$periodo}", now()->addMinutes(15), function () {
            $costService = new CarrierCostAllocationService();
            $carrierIds = Carrier::where('ativo', true)->pluck('id')->toArray();
            $evolucao = [];

            // Gera lista de meses
            $meses = [];
            for ($i = 5; $i >= 0; $i--) {
                $data = Carbon::create($this->ano, $this->mes, 1)->subMonths($i);
                $meses[] = [
                    'mes' => $data->month,
                    'ano' => $data->year,
                    'formato' => $data->format('m/Y'),
                ];
            }

            // Busca receitas de todos os 6 meses em uma única query
            $receitasPorMes = RevenueSummary::whereIn('ano', collect($meses)->pluck('ano')->unique())
                ->whereIn('mes', collect($meses)->pluck('mes')->unique())
                ->selectRaw('
                    ano,
                    mes,
                    SUM(custo_total) as receita_chamadas,
                    SUM(produtos_receita) as receita_produtos
                ')
                ->groupBy('ano', 'mes')
                ->get()
                ->keyBy(function ($item) {
                    return "{$item->ano}-{$item->mes}";
                });

            // Processa cada mês com batch processing
            foreach ($meses as $mesData) {
                $key = "{$mesData['ano']}-{$mesData['mes']}";
                $receitaItem = $receitasPorMes->get($key);

                $receitaMes = ($receitaItem->receita_chamadas ?? 0) + ($receitaItem->receita_produtos ?? 0);

                // BATCH PROCESSING: Calcula custos de todas carriers em 3 queries
                // Antes: 5 queries × N carriers por mês = 150+ queries para 6 meses
                // Depois: 3 queries × 6 meses = 18 queries
                $custosMes = $costService->calcularCustoRealMultiplos($carrierIds, $mesData['mes'], $mesData['ano']);
                $custoMes = collect($custosMes)->sum('custo_total');

                $evolucao[] = [
                    'mes' => $mesData['formato'],
                    'receita' => $receitaMes,
                    'custo' => $custoMes,
                    'lucro' => $receitaMes - $custoMes,
                ];
            }

            return $evolucao;
        });

        // Top 5 clientes por receita (cache de 10 minutos)
        $topClientes = Cache::remember("financial:top_clientes:{$periodo}", now()->addMinutes(10), function () {
            return RevenueSummary::with(['customer' => function($query) {
                    $query->select('id', 'nomefantasia', 'razaosocial', 'ativo');
                }])
                ->where('mes', $this->mes)
                ->where('ano', $this->ano)
                ->selectRaw('*, (custo_total + produtos_receita) as receita_total_calculada')
                ->orderBy('receita_total_calculada', 'desc')
                ->limit(5)
                ->get();
        });

        // Distribuição por tipo de serviço (cache de 10 minutos)
        $distribuicaoServico = Cache::remember("financial:distribuicao:{$periodo}", now()->addMinutes(10), function () {
            return RevenueSummary::where('mes', $this->mes)
                ->where('ano', $this->ano)
                ->selectRaw('
                    SUM(excedente_fixo) as fixo,
                    SUM(excedente_movel) as movel,
                    SUM(excedente_internacional) as internacional
                ')
                ->first();
        });

        // Custos por operadora - com detalhamento fixo + variável
        $custosOperadora = collect($custosDetalhados)->map(function ($detalhes, $carrierId) {
            $carrier = Carrier::find($carrierId);
            return (object)[
                'carrier' => $carrier,
                'total' => $detalhes['custo_total'],
                'custo_fixo' => $detalhes['custo_fixo'],
                'custo_variavel' => $detalhes['custo_variavel'],
                'detalhes' => $detalhes['detalhes'] ?? []
            ];
        })->sortByDesc('total');

        // Comparação com mês anterior (cache de 10 minutos)
        // OTIMIZADO: Usa batch processing
        $comparacao = Cache::remember("financial:comparacao:{$periodo}", now()->addMinutes(10), function () use ($receita, $custo, $lucro, $margemLucro) {
            // Calcular mês anterior
            $mesAnterior = $this->mes - 1;
            $anoAnterior = $this->ano;
            if ($mesAnterior < 1) {
                $mesAnterior = 12;
                $anoAnterior = $this->ano - 1;
            }

            // Buscar métricas do mês anterior
            $receitasAnterior = RevenueSummary::where('mes', $mesAnterior)
                ->where('ano', $anoAnterior)
                ->selectRaw('
                    SUM(custo_total) as receita_chamadas,
                    SUM(produtos_receita) as receita_produtos
                ')
                ->first();

            $receitaAnterior = ($receitasAnterior->receita_chamadas ?? 0) + ($receitasAnterior->receita_produtos ?? 0);

            // BATCH PROCESSING: Custos do mês anterior
            // Antes: 5 queries × N carriers = 25+ queries
            // Depois: 3 queries fixas
            $costService = new CarrierCostAllocationService();
            $carrierIds = Carrier::where('ativo', true)->pluck('id')->toArray();
            $custosAnterior = $costService->calcularCustoRealMultiplos($carrierIds, $mesAnterior, $anoAnterior);
            $custoAnterior = collect($custosAnterior)->sum('custo_total');

            $lucroAnterior = $receitaAnterior - $custoAnterior;
            $margemAnterior = $receitaAnterior > 0 ? ($lucroAnterior / $receitaAnterior) * 100 : 0;

            // Calcular variações
            $variacaoReceita = $receitaAnterior > 0 ? (($receita - $receitaAnterior) / $receitaAnterior) * 100 : 0;
            $variacaoCusto = $custoAnterior > 0 ? (($custo - $custoAnterior) / $custoAnterior) * 100 : 0;
            $variacaoLucro = $lucroAnterior != 0 ? (($lucro - $lucroAnterior) / abs($lucroAnterior)) * 100 : 0;
            $variacaoMargem = $margemLucro - $margemAnterior; // Variação em pontos percentuais

            return [
                'mesAnterior' => $mesAnterior,
                'anoAnterior' => $anoAnterior,
                'variacaoReceita' => $variacaoReceita,
                'variacaoCusto' => $variacaoCusto,
                'variacaoLucro' => $variacaoLucro,
                'variacaoMargem' => $variacaoMargem,
            ];
        });

        return view('livewire.dashboard.financial', compact(
            'totalClientes',
            'receita',
            'receitaChamadas',
            'receitaProdutos',
            'custo',
            'lucro',
            'margemLucro',
            'ticketMedio',
            'evolucao',
            'topClientes',
            'distribuicaoServico',
            'custosOperadora'
        ) + $comparacao);
    }
}
