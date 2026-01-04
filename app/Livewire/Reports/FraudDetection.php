<?php

namespace App\Livewire\Reports;

use App\Models\Cdr;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FraudDetection extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $selectedCustomerId;
    public $detailsModal = false;
    public $fraudDetails;
    public $filterModal = false;

    protected $queryString = [
        'dateStart' => ['except' => ''],
        'dateEnd' => ['except' => ''],
    ];

    public function mount()
    {
        $this->dateStart = Carbon::now()->startOfDay()->format('Y-m-d');
        $this->dateEnd = Carbon::now()->endOfDay()->format('Y-m-d');
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
        $this->dateStart = Carbon::now()->startOfDay()->format('Y-m-d');
        $this->dateEnd = Carbon::now()->endOfDay()->format('Y-m-d');
        $this->resetPage();
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        $periodo = "{$this->dateStart}_{$this->dateEnd}";

        \Illuminate\Support\Facades\Cache::forget("fraud:analysis:{$periodo}");
        \Illuminate\Support\Facades\Cache::forget("fraud:stats:{$periodo}");

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

    public function openDetails($customerId)
    {
        $this->selectedCustomerId = $customerId;
        $customer = Customer::find($customerId);

        $dateStart = Carbon::parse($this->dateStart);
        $dateEnd = Carbon::parse($this->dateEnd);

        // Padrões de fraude detectados
        $patterns = [];

        // 1. Picos de chamadas (>100 calls em 1 hora)
        $callPeaks = Cdr::where('customer_id', $customerId)
            ->whereBetween('calldate', [$dateStart, $dateEnd])
            ->select(
                DB::raw('DATE_TRUNC(\'hour\', calldate) as hora'),
                DB::raw('COUNT(*) as total_chamadas')
            )
            ->groupBy('hora')
            ->having(DB::raw('COUNT(*)'), '>', 100)
            ->orderBy('total_chamadas', 'DESC')
            ->get();

        if ($callPeaks->count() > 0) {
            $patterns[] = [
                'type' => 'call_peak',
                'label' => 'Pico de Chamadas',
                'severity' => 'high',
                'data' => $callPeaks
            ];
        }

        // 2. Chamadas para números premium (0900, 0300)
        $premiumCalls = Cdr::where('customer_id', $customerId)
            ->whereBetween('calldate', [$dateStart, $dateEnd])
            ->where(function ($query) {
                $query->where('dst', 'LIKE', '0900%')
                    ->orWhere('dst', 'LIKE', '0300%');
            })
            ->select('dst', DB::raw('COUNT(*) as total'), DB::raw('SUM(billsec) as duracao_total'))
            ->groupBy('dst')
            ->orderBy('total', 'DESC')
            ->get();

        if ($premiumCalls->count() > 0) {
            $patterns[] = [
                'type' => 'premium_numbers',
                'label' => 'Números Premium',
                'severity' => 'critical',
                'data' => $premiumCalls
            ];
        }

        // 3. Chamadas internacionais suspeitas
        $internationalCalls = Cdr::where('customer_id', $customerId)
            ->whereBetween('calldate', [$dateStart, $dateEnd])
            ->where('dst', 'LIKE', '00%')
            ->select('dst', DB::raw('COUNT(*) as total'), DB::raw('SUM(billsec) as duracao_total'))
            ->groupBy('dst')
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get();

        if ($internationalCalls->count() > 0) {
            $patterns[] = [
                'type' => 'international',
                'label' => 'Chamadas Internacionais',
                'severity' => 'medium',
                'data' => $internationalCalls
            ];
        }

        // 4. Múltiplas chamadas curtas (possível teste de números)
        $shortCalls = Cdr::where('customer_id', $customerId)
            ->whereBetween('calldate', [$dateStart, $dateEnd])
            ->where('billsec', '<', 5)
            ->where('disposition', 'ANSWERED')
            ->select(
                DB::raw('DATE(calldate) as dia'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('dia')
            ->having(DB::raw('COUNT(*)'), '>', 50)
            ->orderBy('total', 'DESC')
            ->get();

        if ($shortCalls->count() > 0) {
            $patterns[] = [
                'type' => 'short_calls',
                'label' => 'Chamadas Curtas Suspeitas',
                'severity' => 'medium',
                'data' => $shortCalls
            ];
        }

        // 5. Chamadas simultâneas excessivas
        $simultaneousCalls = Cdr::where('customer_id', $customerId)
            ->whereBetween('calldate', [$dateStart, $dateEnd])
            ->select(
                DB::raw('DATE_TRUNC(\'minute\', calldate) as minuto'),
                DB::raw('COUNT(*) as simultaneas')
            )
            ->groupBy('minuto')
            ->having(DB::raw('COUNT(*)'), '>', 30)
            ->orderBy('simultaneas', 'DESC')
            ->get();

        if ($simultaneousCalls->count() > 0) {
            $patterns[] = [
                'type' => 'simultaneous',
                'label' => 'Chamadas Simultâneas Excessivas',
                'severity' => 'high',
                'data' => $simultaneousCalls
            ];
        }

        $this->fraudDetails = [
            'customer' => $customer,
            'patterns' => $patterns,
            'summary' => [
                'total_patterns' => count($patterns),
                'highest_severity' => $this->getHighestSeverity($patterns),
            ]
        ];

        $this->detailsModal = true;
    }

    private function getHighestSeverity($patterns)
    {
        $severities = collect($patterns)->pluck('severity');
        if ($severities->contains('critical')) return 'critical';
        if ($severities->contains('high')) return 'high';
        if ($severities->contains('medium')) return 'medium';
        return 'low';
    }

    public function render()
    {
        $dateStart = Carbon::parse($this->dateStart);
        $dateEnd = Carbon::parse($this->dateEnd);

        // Análise de fraude por cliente
        $fraudAnalysis = Customer::query()
            ->select([
                'customers.id',
                'customers.razaosocial',
                'customers.nomefantasia',
                'customers.cnpj',
                'customers.ativo',
                // Total de chamadas no período
                DB::raw('COUNT(cdrs.id) as total_chamadas'),
                // Chamadas para números premium
                DB::raw('SUM(CASE WHEN cdrs.dst LIKE \'0900%\' OR cdrs.dst LIKE \'0300%\' THEN 1 ELSE 0 END) as premium_calls'),
                // Chamadas internacionais
                DB::raw('SUM(CASE WHEN cdrs.dst LIKE \'00%\' THEN 1 ELSE 0 END) as international_calls'),
                // Chamadas curtas suspeitas
                DB::raw('SUM(CASE WHEN cdrs.billsec < 5 AND cdrs.disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as short_calls'),
                // Score de risco (0-100)
                DB::raw('CASE
                    WHEN COUNT(cdrs.id) = 0 THEN 0
                    ELSE (
                        (SUM(CASE WHEN cdrs.dst LIKE \'0900%\' OR cdrs.dst LIKE \'0300%\' THEN 1 ELSE 0 END)::numeric / COUNT(cdrs.id) * 50) +
                        (SUM(CASE WHEN cdrs.dst LIKE \'00%\' THEN 1 ELSE 0 END)::numeric / COUNT(cdrs.id) * 30) +
                        (SUM(CASE WHEN cdrs.billsec < 5 AND cdrs.disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / COUNT(cdrs.id) * 20)
                    )
                END as risk_score')
            ])
            ->leftJoin('cdrs', function ($join) use ($dateStart, $dateEnd) {
                $join->on('customers.id', '=', 'cdrs.customer_id')
                    ->whereBetween('cdrs.calldate', [$dateStart, $dateEnd]);
            })
            ->where('customers.ativo', true)
            ->groupBy('customers.id', 'customers.razaosocial', 'customers.nomefantasia', 'customers.cnpj', 'customers.ativo')
            ->having(DB::raw('COUNT(cdrs.id)'), '>', 0)
            ->orderBy('risk_score', 'DESC')
            ->paginate(20);

        // Estatísticas gerais
        $stats = (object) [
            'high_risk' => $fraudAnalysis->where('risk_score', '>=', 70)->count(),
            'medium_risk' => $fraudAnalysis->whereBetween('risk_score', [40, 69])->count(),
            'low_risk' => $fraudAnalysis->where('risk_score', '<', 40)->where('risk_score', '>', 0)->count(),
            'total_premium' => $fraudAnalysis->sum('premium_calls'),
            'total_international' => $fraudAnalysis->sum('international_calls'),
        ];

        return view('livewire.reports.fraud-detection', compact('fraudAnalysis', 'stats'));
    }
}
