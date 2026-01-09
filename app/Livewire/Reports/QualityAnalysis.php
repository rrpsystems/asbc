<?php

namespace App\Livewire\Reports;

use App\Livewire\Traits\Table;
use App\Models\Carrier;
use App\Models\Cdr;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class QualityAnalysis extends Component
{
    use Table;

    public $data_inicial;
    public $data_final;
    public $group_by = 'customer'; // customer, carrier, daily
    public $carrier_id = 'all';
    public $filterModal = false;
    public $detailsModal = false;
    public $selectedItem;
    public $selectedType;

    public function mount()
    {
        $this->data_inicial = Carbon::now()->startOfMonth()->toDateString();
        $this->data_final = Carbon::now()->toDateString();
        $this->direction = 'DESC';
        $this->sort = 'asr';
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

    public function openDetails($id, $type)
    {
        $this->selectedType = $type;

        if ($type === 'customer') {
            $this->selectedItem = Customer::find($id);
        } elseif ($type === 'carrier') {
            $this->selectedItem = Carrier::find($id);
        }

        $this->detailsModal = true;
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\QualityAnalysisExport($this->data_inicial, $this->data_final, $this->group_by),
            'analise_qualidade_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    public function render()
    {
        $query = Cdr::query()
            ->whereBetween('calldate', [
                $this->data_inicial . ' 00:00:00',
                $this->data_final . ' 23:59:59'
            ]);

        // Filtro por operadora (se selecionado)
        if ($this->carrier_id !== 'all') {
            $query->where('carrier_id', $this->carrier_id);
        }

        // Análise de códigos SIP e Q.850
        $sipAnalysis = Cdr::whereBetween('calldate', [
            $this->data_inicial . ' 00:00:00',
            $this->data_final . ' 23:59:59'
        ])
            ->when($this->carrier_id !== 'all', fn($q) => $q->where('carrier_id', $this->carrier_id))
            ->select([
                'sip_code',
                'sip_reason',
                DB::raw('COUNT(*) as total'),
                DB::raw('ROUND((COUNT(*)::numeric / (SELECT COUNT(*) FROM cdrs WHERE calldate BETWEEN \'' . $this->data_inicial . ' 00:00:00\' AND \'' . $this->data_final . ' 23:59:59\'' . ($this->carrier_id !== 'all' ? ' AND carrier_id = ' . $this->carrier_id : '') . ')) * 100, 2) as percentage')
            ])
            ->whereNotNull('sip_code')
            ->groupBy('sip_code', 'sip_reason')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $q850Analysis = Cdr::whereBetween('calldate', [
            $this->data_inicial . ' 00:00:00',
            $this->data_final . ' 23:59:59'
        ])
            ->when($this->carrier_id !== 'all', fn($q) => $q->where('carrier_id', $this->carrier_id))
            ->select([
                'q850_cause',
                'q850_description',
                DB::raw('COUNT(*) as total'),
                DB::raw('ROUND((COUNT(*)::numeric / (SELECT COUNT(*) FROM cdrs WHERE calldate BETWEEN \'' . $this->data_inicial . ' 00:00:00\' AND \'' . $this->data_final . ' 23:59:59\'' . ($this->carrier_id !== 'all' ? ' AND carrier_id = ' . $this->carrier_id : '') . ' AND q850_cause IS NOT NULL)) * 100, 2) as percentage')
            ])
            ->whereNotNull('q850_cause')
            ->groupBy('q850_cause', 'q850_description')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $failureTypeAnalysis = Cdr::whereBetween('calldate', [
            $this->data_inicial . ' 00:00:00',
            $this->data_final . ' 23:59:59'
        ])
            ->when($this->carrier_id !== 'all', fn($q) => $q->where('carrier_id', $this->carrier_id))
            ->select([
                'failure_type',
                DB::raw('COUNT(*) as total'),
                DB::raw('ROUND((COUNT(*)::numeric / (SELECT COUNT(*) FROM cdrs WHERE calldate BETWEEN \'' . $this->data_inicial . ' 00:00:00\' AND \'' . $this->data_final . ' 23:59:59\'' . ($this->carrier_id !== 'all' ? ' AND carrier_id = ' . $this->carrier_id : '') . ' AND failure_type IS NOT NULL)) * 100, 2) as percentage')
            ])
            ->whereNotNull('failure_type')
            ->groupBy('failure_type')
            ->orderByDesc('total')
            ->get();

        // Agrupa conforme seleção
        if ($this->group_by === 'customer') {
            $data = $query->select([
                'customer_id',
                DB::raw('MAX(customers.razaosocial) as nome'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
                ->join('customers', 'cdrs.customer_id', '=', 'customers.id')
                ->groupBy('customer_id')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->perPage);
        } elseif ($this->group_by === 'carrier') {
            $data = $query->select([
                'carrier_id',
                DB::raw('MAX(carriers.operadora) as nome'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
                ->join('carriers', 'cdrs.carrier_id', '=', 'carriers.id')
                ->groupBy('carrier_id')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->perPage);
        } else { // daily
            $data = $query->select([
                DB::raw('DATE(calldate) as data'),
                DB::raw('DATE(calldate) as nome'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
                ->groupBy(DB::raw('DATE(calldate)'))
                ->orderBy(DB::raw('DATE(calldate)'), 'DESC')
                ->paginate($this->perPage);
        }

        // Calcula totais gerais
        $totalsQuery = Cdr::whereBetween('calldate', [
            $this->data_inicial . ' 00:00:00',
            $this->data_final . ' 23:59:59'
        ]);

        // Aplica filtro de operadora nos totais também
        if ($this->carrier_id !== 'all') {
            $totalsQuery->where('carrier_id', $this->carrier_id);
        }

        $totals = $totalsQuery
            ->select([
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
            ->first();

        // Lista de operadoras para o filtro
        $carriers = Carrier::where('ativo', true)->orderBy('operadora')->get();

        return view('livewire.reports.quality-analysis', compact('data', 'totals', 'carriers', 'sipAnalysis', 'q850Analysis', 'failureTypeAnalysis'));
    }
}
