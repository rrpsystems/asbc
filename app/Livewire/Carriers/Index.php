<?php

namespace App\Livewire\Carriers;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\Table;
use App\Models\Carrier;

class Index extends Component
{
    use Table;

    public $filterStatus = '';
    public $filterFranquiaCompartilhada = '';
    public $filterModal = false;

    #[On('table-update')]
    public function render()
    {
        $query = Carrier::query()
            ->where(function($q) {
                $q->where('operadora', 'like', '%' . $this->search . '%')
                  ->orWhere('proxy', 'like', '%' . $this->search . '%');
            });

        // Apply filters
        if ($this->filterStatus !== '') {
            $query->where('ativo', $this->filterStatus === '1');
        }

        if ($this->filterFranquiaCompartilhada !== '') {
            $query->where('franquia_compartilhada', $this->filterFranquiaCompartilhada === '1');
        }

        $carriers = $query->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Calculate statistics
        $stats = (object) [
            'total' => Carrier::count(),
            'ativos' => Carrier::where('ativo', true)->count(),
            'inativos' => Carrier::where('ativo', false)->count(),
            'canais_total' => Carrier::where('ativo', true)->sum('canais'),
        ];

        return view('livewire.carriers.index', [
            'carriers' => $carriers,
            'stats' => $stats,
        ]);
    }

    public function openFilterModal()
    {
        $this->filterModal = true;
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterFranquiaCompartilhada = '';
        $this->search = '';
    }
}
