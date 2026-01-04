<?php

namespace App\Livewire\Carriers;

use App\Models\Carrier;
use App\Models\Customer;
use App\Models\RevenueSummary;
use App\Services\CarrierCostAllocationService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CostAllocation extends Component
{
    public $mes;
    public $ano;
    public $carrier_id;
    public $tipo_alocacao = 'cliente'; // 'cliente' ou 'did'

    public function mount()
    {
        $this->mes = now()->month;
        $this->ano = now()->year;
        $this->carrier_id = Carrier::where('ativo', true)->first()?->id;
    }

    /**
     * Limpa filtros e volta ao padrão
     */
    public function clearFilters()
    {
        $this->mes = now()->month;
        $this->ano = now()->year;
        $this->carrier_id = Carrier::where('ativo', true)->first()?->id;
        $this->tipo_alocacao = 'cliente';
    }

    /**
     * Força atualização dos dados
     */
    public function refresh()
    {
        session()->flash('message', 'Dados atualizados com sucesso!');
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
        $carriers = Carrier::where('ativo', true)->orderBy('operadora')->get();

        if (!$this->carrier_id) {
            return view('livewire.carriers.cost-allocation', [
                'carriers' => $carriers,
                'alocacoes' => collect([]),
                'custoTotal' => 0,
                'custoFixo' => 0,
                'custoVariavel' => 0,
            ]);
        }

        $costService = new CarrierCostAllocationService();

        // Calcular custo real da operadora
        $custoReal = $costService->calcularCustoReal($this->carrier_id, $this->mes, $this->ano);

        // Calcular custo do mês anterior para comparação
        $mesAnterior = $this->mes - 1;
        $anoAnterior = $this->ano;
        if ($mesAnterior < 1) {
            $mesAnterior = 12;
            $anoAnterior = $this->ano - 1;
        }

        $custoRealAnterior = $costService->calcularCustoReal($this->carrier_id, $mesAnterior, $anoAnterior);

        // Calcular variações
        $variacaoCustoTotal = 0;
        $variacaoCustoFixo = 0;
        $variacaoCustoVariavel = 0;

        if ($custoRealAnterior['custo_total'] > 0) {
            $variacaoCustoTotal = (($custoReal['custo_total'] - $custoRealAnterior['custo_total']) / $custoRealAnterior['custo_total']) * 100;
        }
        if ($custoRealAnterior['custo_fixo'] > 0) {
            $variacaoCustoFixo = (($custoReal['custo_fixo'] - $custoRealAnterior['custo_fixo']) / $custoRealAnterior['custo_fixo']) * 100;
        }
        if ($custoRealAnterior['custo_variavel'] > 0) {
            $variacaoCustoVariavel = (($custoReal['custo_variavel'] - $custoRealAnterior['custo_variavel']) / $custoRealAnterior['custo_variavel']) * 100;
        }

        // Buscar alocações conforme tipo selecionado
        if ($this->tipo_alocacao === 'cliente') {
            $alocacoes = $costService->ratearCustoFixoPorCliente($this->carrier_id, $this->mes, $this->ano);

            // Calcular total de DIDs para percentual
            $totalDids = collect($alocacoes)->sum('quantidade_dids');

            // Buscar todos os customers e revenues de uma vez
            $customerIds = collect($alocacoes)->pluck('customer_id')->unique()->toArray();
            $customers = Customer::whereIn('id', $customerIds)
                ->select('id', 'nomefantasia', 'razaosocial')
                ->get()
                ->keyBy('id');
            $revenues = RevenueSummary::whereIn('customer_id', $customerIds)
                ->where('mes', $this->mes)
                ->where('ano', $this->ano)
                ->get()
                ->keyBy('customer_id');

            // Enriquecer com dados do cliente
            $alocacoes = collect($alocacoes)->map(function ($item) use ($customers, $revenues, $totalDids) {
                $customer = $customers->get($item['customer_id']);
                $revenue = $revenues->get($item['customer_id']);

                // Percentual baseado em DIDs, não minutos
                $percentual = $totalDids > 0 ? ($item['quantidade_dids'] / $totalDids) * 100 : 0;

                return [
                    'nome' => $customer?->nomefantasia ?? $customer?->razaosocial ?? 'Cliente #' . $item['customer_id'],
                    'customer_id' => $item['customer_id'],
                    'quantidade_dids' => $item['quantidade_dids'],
                    'minutos' => $item['minutos'],
                    'percentual' => $percentual,
                    'custo_fixo_rateado' => $item['custo_fixo_rateado'],
                    'custo_variavel' => $item['custo_variavel'],
                    'custo_total' => $item['custo_total'],
                    'receita' => $revenue?->custo_total ?? 0,
                    'lucro' => ($revenue?->custo_total ?? 0) - $item['custo_total'],
                ];
            })->sortByDesc('custo_total');
        } else {
            $alocacoes = $costService->ratearCustoPorDid($this->carrier_id, $this->mes, $this->ano);

            $alocacoes = collect($alocacoes)->map(function ($item) {
                return [
                    'did' => $item['numero'] ?? 'N/A',
                    'customer_nome' => $item['customer_nome'] ?? 'Não atribuído',
                    'custo_contratado' => $item['custo_contratado'] ?? 0,
                    'custo_real_ativo' => $item['custo_real_ativo'] ?? 0,
                    'custo_ociosos' => $item['custo_ociosos'] ?? 0,
                    'custo_variavel_excedente' => $item['custo_variavel_excedente'] ?? 0,
                    'custo_variavel' => $item['custo_variavel'] ?? 0,
                    'custo_total' => $item['custo_total'] ?? 0,
                ];
            })->sortByDesc('custo_total');
        }

        return view('livewire.carriers.cost-allocation', [
            'carriers' => $carriers,
            'alocacoes' => $alocacoes,
            'custoTotal' => $custoReal['custo_total'],
            'custoFixo' => $custoReal['custo_fixo'],
            'custoVariavel' => $custoReal['custo_variavel'],
            'detalhes' => $custoReal['detalhes'] ?? [],
            'variacaoCustoTotal' => $variacaoCustoTotal,
            'variacaoCustoFixo' => $variacaoCustoFixo,
            'variacaoCustoVariavel' => $variacaoCustoVariavel,
            'mesAnterior' => $mesAnterior,
            'anoAnterior' => $anoAnterior,
        ]);
    }
}
