<?php

namespace App\Livewire\Alerts;

use App\Services\AlertService;
use Livewire\Component;

class Notification extends Component
{
    public $unreadCount = 0;
    public $criticalCount = 0;

    protected $alertService;

    public function boot(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function mount()
    {
        $this->loadCounts();
    }

    public function loadCounts()
    {
        $stats = $this->alertService->countUnreadBySeverity();
        $this->criticalCount = $stats['critical'];
        $this->unreadCount = $stats['critical'] + $stats['high'] + $stats['medium'] + $stats['low'];
    }

    public function render()
    {
        return view('livewire.alerts.notification');
    }
}
