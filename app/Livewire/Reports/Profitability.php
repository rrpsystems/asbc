<?php

namespace App\Livewire\Reports;

use App\Livewire\Traits\Table;
use App\Models\Customer;
use App\Models\RevenueSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Profitability extends Component
{
    use Table;

    public $mes;
    public $ano;
    public $filterModal = false;
    public $detailsModal = false;
    public $selectedCustomer;
    public $customerHistory = [];

    public function mount()
    {
        $this->mes = Carbon::now()->month;
        $this->ano = Carbon::now()->year;
        $this->direction = 'DESC';
        $this->sort = 'margem_lucro';
    }

    public function openFilter()
    {
        $this->filterModal = true;
    }

    public function closeFilterModal()
    {
        $this->filterModal = false;
    }

    public function applyFilter()
    {
        $this->resetPage();
        $this->filterModal = false;
    }

    public function openDetails($customerId)
    {
        $this->selectedCustomer = Customer::find($customerId);

        // Busca histórico dos últimos 6 meses
        $this->customerHistory = RevenueSummary::where('customer_id', $customerId)
            ->where('ano', '>=', Carbon::now()->subMonths(6)->year)
            ->orderBy('ano', 'DESC')
            ->orderBy('mes', 'DESC')
            ->limit(6)
            ->get()
            ->map(function ($resumo) {
                return [
                    'periodo' => Carbon::create($resumo->ano, $resumo->mes, 1)->format('m/Y'),
                    'receita_total' => $resumo->receita_total ?? $resumo->custo_total,
                    'custo_total' => $resumo->custo_total,
                    'produtos_receita' => $resumo->produtos_receita ?? 0,
                    'margem_lucro' => ($resumo->receita_total ?? $resumo->custo_total) - $resumo->custo_total,
                    'percentual' => $resumo->custo_total > 0
                        ? ((($resumo->receita_total ?? $resumo->custo_total) - $resumo->custo_total) / $resumo->custo_total) * 100
                        : 0,
                ];
            });

        $this->detailsModal = true;
    }

    /**
     * Limpa filtros e volta ao padrão
     */
    public function clearFilters()
    {
        $this->mes = Carbon::now()->month;
        $this->ano = Carbon::now()->year;
        $this->filterModal = false;
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        $periodo = "{$this->ano}-{$this->mes}";

        \Illuminate\Support\Facades\Cache::forget("profitability:data:{$periodo}");
        \Illuminate\Support\Facades\Cache::forget("profitability:totals:{$periodo}");
        \Illuminate\Support\Facades\Cache::forget("profitability:comparison:{$periodo}");

        session()->flash('message', 'Dados atualizados com sucesso!');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ProfitabilityExport($this->mes, $this->ano),
            'rentabilidade_' . $this->mes . '_' . $this->ano . '.xlsx'
        );
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

        // Busca resumos do mês/ano selecionado com cálculos de rentabilidade
        $profitability = RevenueSummary::query()
            ->select([
                'revenue_summaries.*',
                'customers.razaosocial',
                'customers.nomefantasia',
                DB::raw('COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) as receita_final'),
                DB::raw('COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) - revenue_summaries.custo_total as margem_lucro'),
                DB::raw('CASE
                    WHEN revenue_summaries.custo_total > 0 THEN
                        ((COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) - revenue_summaries.custo_total) / revenue_summaries.custo_total) * 100
                    ELSE 0
                END as percentual_rentabilidade')
            ])
            ->join('customers', 'revenue_summaries.customer_id', '=', 'customers.id')
            ->where('revenue_summaries.mes', $this->mes)
            ->where('revenue_summaries.ano', $this->ano)
            ->where('customers.ativo', true)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Calcula totalizadores com cache (10 minutos)
        $totals = \Illuminate\Support\Facades\Cache::remember("profitability:totals:{$periodo}", now()->addMinutes(10), function () {
            $totals = RevenueSummary::where('mes', $this->mes)
                ->where('ano', $this->ano)
                ->whereHas('customer', function ($query) {
                    $query->where('ativo', true);
                })
                ->select([
                    DB::raw('SUM(COALESCE(receita_total, custo_total)) as total_receita'),
                    DB::raw('SUM(custo_total) as total_custo'),
                    DB::raw('SUM(COALESCE(produtos_receita, 0)) as total_produtos'),
                    DB::raw('SUM(COALESCE(receita_total, custo_total) - custo_total) as total_margem'),
                ])
                ->first();

            $totals->percentual_medio = $totals->total_custo > 0
                ? (($totals->total_margem / $totals->total_custo) * 100)
                : 0;

            return $totals;
        });

        // Comparação com mês anterior (cache de 10 minutos)
        $comparacao = \Illuminate\Support\Facades\Cache::remember("profitability:comparison:{$periodo}", now()->addMinutes(10), function () use ($totals) {
            // Calcular mês anterior
            $mesAnterior = $this->mes - 1;
            $anoAnterior = $this->ano;
            if ($mesAnterior < 1) {
                $mesAnterior = 12;
                $anoAnterior = $this->ano - 1;
            }

            // Buscar totais do mês anterior
            $totalsAnterior = RevenueSummary::where('mes', $mesAnterior)
                ->where('ano', $anoAnterior)
                ->whereHas('customer', function ($query) {
                    $query->where('ativo', true);
                })
                ->select([
                    DB::raw('SUM(COALESCE(receita_total, custo_total)) as total_receita'),
                    DB::raw('SUM(custo_total) as total_custo'),
                    DB::raw('SUM(COALESCE(receita_total, custo_total) - custo_total) as total_margem'),
                ])
                ->first();

            if (!$totalsAnterior) {
                return [
                    'mesAnterior' => $mesAnterior,
                    'anoAnterior' => $anoAnterior,
                ];
            }

            $percentualAnterior = $totalsAnterior->total_custo > 0
                ? (($totalsAnterior->total_margem / $totalsAnterior->total_custo) * 100)
                : 0;

            // Calcular variações
            $variacaoReceita = $totalsAnterior->total_receita > 0
                ? ((($totals->total_receita ?? 0) - $totalsAnterior->total_receita) / $totalsAnterior->total_receita) * 100
                : 0;

            $variacaoCusto = $totalsAnterior->total_custo > 0
                ? ((($totals->total_custo ?? 0) - $totalsAnterior->total_custo) / $totalsAnterior->total_custo) * 100
                : 0;

            $variacaoMargem = $totalsAnterior->total_margem != 0
                ? ((($totals->total_margem ?? 0) - $totalsAnterior->total_margem) / abs($totalsAnterior->total_margem)) * 100
                : 0;

            $variacaoRentabilidade = ($totals->percentual_medio ?? 0) - $percentualAnterior;

            return [
                'mesAnterior' => $mesAnterior,
                'anoAnterior' => $anoAnterior,
                'variacaoReceita' => $variacaoReceita,
                'variacaoCusto' => $variacaoCusto,
                'variacaoMargem' => $variacaoMargem,
                'variacaoRentabilidade' => $variacaoRentabilidade,
            ];
        });

        return view('livewire.reports.profitability', compact('profitability', 'totals') + $comparacao);
    }
}
