<?php

namespace App\Livewire\Reports;

use App\Models\Carrier;
use App\Models\Cdr;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RouteAnalysis extends Component
{
    use WithPagination;

    public $mes;
    public $ano;
    public $selectedPrefix;
    public $detailsModal = false;
    public $routeDetails;
    public $filterModal = false;

    protected $queryString = [
        'mes' => ['except' => ''],
        'ano' => ['except' => ''],
    ];

    public function mount()
    {
        $this->mes = Carbon::now()->month;
        $this->ano = Carbon::now()->year;
    }

    public function openFilterModal()
    {
        $this->filterModal = true;
    }

    public function closeFilterModal()
    {
        $this->filterModal = false;
    }

    public function filter()
    {
        $this->resetPage();
        $this->filterModal = false;
    }

    /**
     * Limpa filtros e volta ao padrão
     */
    public function clearFilters()
    {
        $this->mes = Carbon::now()->month;
        $this->ano = Carbon::now()->year;
        $this->resetPage();
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        $periodo = "{$this->ano}-{$this->mes}";

        \Illuminate\Support\Facades\Cache::forget("route:analysis:{$periodo}");
        \Illuminate\Support\Facades\Cache::forget("route:stats:{$periodo}");

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

    public function openDetails($prefix)
    {
        $this->selectedPrefix = $prefix;

        $startDate = Carbon::create($this->ano, $this->mes, 1)->startOfMonth();
        $endDate = Carbon::create($this->ano, $this->mes, 1)->endOfMonth();

        // Buscar todas as operadoras disponíveis para este prefixo
        $availableCarriers = Rate::where('prefixo', $prefix)
            ->join('carriers', 'rates.carrier_id', '=', 'carriers.id')
            ->where('carriers.ativo', true)
            ->where('rates.ativo', true)
            ->select(
                'carriers.id',
                'carriers.operadora as nome',
                'rates.compra as custo_por_minuto',
                'rates.compra as custo_efetivo'
            )
            ->orderBy('custo_efetivo', 'ASC')
            ->get();

        // Buscar uso atual por operadora para este prefixo
        $currentUsage = Cdr::whereBetween('calldate', [$startDate, $endDate])
            ->where('dst', 'LIKE', $prefix . '%')
            ->join('carriers', 'cdrs.carrier_id', '=', 'carriers.id')
            ->select(
                'carriers.id',
                'carriers.nome',
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(billsec) as total_segundos'),
                DB::raw('AVG(valor_compra) as custo_medio'),
                DB::raw('SUM(valor_compra) as custo_total')
            )
            ->groupBy('carriers.id', 'carriers.nome')
            ->get();

        // Calcular economia potencial usando LCR
        $lcrCarrier = $availableCarriers->first(); // Menor custo
        $totalMinutes = $currentUsage->sum('total_segundos') / 60;
        $currentCost = $currentUsage->sum('custo_total');
        $lcrCost = $lcrCarrier ? ($totalMinutes * $lcrCarrier->custo_efetivo) : 0;
        $potentialSavings = $currentCost - $lcrCost;
        $savingsPercent = $currentCost > 0 ? (($potentialSavings / $currentCost) * 100) : 0;

        $this->routeDetails = [
            'prefix' => $prefix,
            'available_carriers' => $availableCarriers,
            'current_usage' => $currentUsage,
            'summary' => [
                'total_minutes' => $totalMinutes,
                'current_cost' => $currentCost,
                'lcr_cost' => $lcrCost,
                'potential_savings' => $potentialSavings,
                'savings_percent' => $savingsPercent,
                'best_carrier' => $lcrCarrier,
            ]
        ];

        $this->detailsModal = true;
    }

    public function render()
    {
        $startDate = Carbon::create($this->ano, $this->mes, 1)->startOfMonth();
        $endDate = Carbon::create($this->ano, $this->mes, 1)->endOfMonth();

        // Análise de rotas - Agrupa por prefixo (primeiros 4-5 dígitos)
        $routeAnalysis = Cdr::query()
            ->whereBetween('calldate', [$startDate, $endDate])
            ->select([
                DB::raw('SUBSTRING(dst, 1, 4) as prefix'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(billsec) as total_segundos'),
                DB::raw('SUM(valor_compra) as custo_atual'),
                DB::raw('AVG(valor_compra) as custo_medio'),
                // Conta quantas operadoras diferentes foram usadas
                DB::raw('COUNT(DISTINCT carrier_id) as operadoras_usadas')
            ])
            ->groupBy('prefix')
            ->having(DB::raw('COUNT(*)'), '>', 10) // Apenas prefixos com volume significativo
            ->orderBy('custo_atual', 'DESC')
            ->paginate(20);

        // Para cada prefixo, calcular o potencial LCR
        foreach ($routeAnalysis as $route) {
            // Buscar a tarifa mais barata para este prefixo
            $bestRate = Rate::where('prefixo', $route->prefix)
                ->join('carriers', 'rates.carrier_id', '=', 'carriers.id')
                ->where('carriers.ativo', true)
                ->where('rates.ativo', true)
                ->select(
                    'rates.compra as custo_por_minuto',
                    'rates.compra as custo_efetivo'
                )
                ->orderBy('custo_efetivo', 'ASC')
                ->first();

            if ($bestRate) {
                $minutosTotal = $route->total_segundos / 60;
                $custoLcr = $minutosTotal * $bestRate->custo_efetivo;
                $route->custo_lcr = $custoLcr;
                $route->economia_potencial = $route->custo_atual - $custoLcr;
                $route->economia_percentual = $route->custo_atual > 0
                    ? (($route->economia_potencial / $route->custo_atual) * 100)
                    : 0;
            } else {
                $route->custo_lcr = $route->custo_atual;
                $route->economia_potencial = 0;
                $route->economia_percentual = 0;
            }
        }

        // Estatísticas gerais
        $stats = (object) [
            'total_cost' => $routeAnalysis->sum('custo_atual'),
            'lcr_cost' => $routeAnalysis->sum('custo_lcr'),
            'total_savings' => $routeAnalysis->sum('economia_potencial'),
            'avg_savings_percent' => $routeAnalysis->avg('economia_percentual'),
            'routes_with_savings' => $routeAnalysis->where('economia_potencial', '>', 0)->count(),
        ];

        return view('livewire.reports.route-analysis', compact('routeAnalysis', 'stats'));
    }
}
