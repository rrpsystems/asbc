<?php

namespace App\Livewire\Alerts;

use App\Livewire\Traits\Table;
use App\Models\Alert;
use App\Services\AlertService;
use Livewire\Component;

class Index extends Component
{
    use Table;

    public $filters = [];
    public $filterModal = false;
    public $detailsModal = false;
    public $selectedAlert;
    public $severities;
    public $types;
    public $selectedSeverity = [];
    public $selectedType = [];
    public $showResolved = false;

    protected $alertService;

    public function boot(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function mount()
    {
        $this->direction = 'DESC';
        $this->sort = 'created_at';

        $this->severities = [
            ['label' => 'Todos', 'value' => 'All'],
            ['label' => 'Crítico', 'value' => Alert::SEVERITY_CRITICAL],
            ['label' => 'Alto', 'value' => Alert::SEVERITY_HIGH],
            ['label' => 'Médio', 'value' => Alert::SEVERITY_MEDIUM],
            ['label' => 'Baixo', 'value' => Alert::SEVERITY_LOW],
        ];

        $this->types = [
            ['label' => 'Todos', 'value' => 'All'],
            ['label' => 'Franquia Excedida', 'value' => Alert::TYPE_FRANCHISE_EXCEEDED],
            ['label' => 'Aviso de Franquia', 'value' => Alert::TYPE_FRANCHISE_WARNING],
            ['label' => 'Erro na Tarifação', 'value' => Alert::TYPE_TARIFACAO_ERROR],
            ['label' => 'Pico de Canais', 'value' => Alert::TYPE_PEAK_CHANNELS],
            ['label' => 'Fraude Detectada', 'value' => Alert::TYPE_FRAUD_DETECTED],
            ['label' => 'Custo Elevado', 'value' => Alert::TYPE_HIGH_COST],
            ['label' => 'Falha na Operadora', 'value' => Alert::TYPE_CARRIER_FAILURE],
        ];

        $this->resetFilter();
    }

    public function openDetails($alertId)
    {
        $this->selectedAlert = Alert::with(['customer', 'carrier'])->find($alertId);

        // Mark as read when opening
        if ($this->selectedAlert && !$this->selectedAlert->isRead()) {
            $this->selectedAlert->markAsRead();
        }

        $this->detailsModal = true;
    }

    public function markAsRead($alertId)
    {
        $alert = Alert::find($alertId);
        if ($alert) {
            $alert->markAsRead();
        }
    }

    public function markAsResolved($alertId)
    {
        $alert = Alert::find($alertId);
        if ($alert) {
            $alert->markAsResolved();
        }
        $this->detailsModal = false;
    }

    public function markAllAsRead()
    {
        Alert::unread()->update(['read_at' => now()]);
    }

    public function openFilter()
    {
        $this->filterModal = true;
    }

    public function filter()
    {
        $severity = $this->selectedSeverity;
        if (is_array($severity) && in_array('All', $severity)) {
            $severity = [
                Alert::SEVERITY_CRITICAL,
                Alert::SEVERITY_HIGH,
                Alert::SEVERITY_MEDIUM,
                Alert::SEVERITY_LOW
            ];
        }

        $type = $this->selectedType;
        if (is_array($type) && in_array('All', $type)) {
            $type = [
                Alert::TYPE_FRANCHISE_EXCEEDED,
                Alert::TYPE_FRANCHISE_WARNING,
                Alert::TYPE_TARIFACAO_ERROR,
                Alert::TYPE_PEAK_CHANNELS,
                Alert::TYPE_FRAUD_DETECTED,
                Alert::TYPE_HIGH_COST,
                Alert::TYPE_CARRIER_FAILURE,
            ];
        }

        $this->filters['severity'] = $severity;
        $this->filters['type'] = $type;
        $this->filters['show_resolved'] = $this->showResolved;

        $this->resetPage();
        $this->filterModal = false;
    }

    public function resetFilter()
    {
        $this->selectedSeverity = ['All'];
        $this->selectedType = ['All'];
        $this->showResolved = false;
        $this->filter();
    }

    public function closeFilterModal()
    {
        $this->filterModal = false;
    }

    public function render()
    {
        $alerts = Alert::query()
            ->with(['customer:id,razaosocial', 'carrier:id,operadora'])
            ->when(!empty($this->filters['severity']), function ($query) {
                $query->whereIn('severity', $this->filters['severity']);
            })
            ->when(!empty($this->filters['type']), function ($query) {
                $query->whereIn('type', $this->filters['type']);
            })
            ->when(!$this->filters['show_resolved'], function ($query) {
                $query->unresolved();
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        $stats = $this->alertService->countUnreadBySeverity();

        return view('livewire.alerts.alerts-list', compact('alerts', 'stats'));
    }
}
