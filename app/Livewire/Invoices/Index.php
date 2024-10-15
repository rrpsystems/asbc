<?php

namespace App\Livewire\Invoices;

use App\Livewire\Traits\Table;
use App\Models\RevenueSummary;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    #[On('table-update')]
    public function render()
    {
        $this->direction = 'desc';
        $invoices = RevenueSummary::orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.invoices.index', compact('invoices'));
    }
}
