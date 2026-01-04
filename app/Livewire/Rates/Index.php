<?php

namespace App\Livewire\Rates;

use App\Livewire\Traits\Table;
use App\Models\Carrier;
use App\Models\Rate;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    public $filterStatus = '';
    public $filterTarifa = '';
    public $filterCarrier = '';
    public $filterModal = false;

    #[On('table-update')]
    public function render()
    {
        $query = Rate::with('carrier')
            ->where(function($q) {
                $q->where('descricao', 'like', '%'.$this->search.'%')
                  ->orWhere('prefixo', 'like', '%'.$this->search.'%');
            });

        // Apply filters
        if ($this->filterStatus !== '') {
            $query->where('ativo', $this->filterStatus === '1');
        }

        if ($this->filterTarifa !== '') {
            $query->where('tarifa', $this->filterTarifa);
        }

        if ($this->filterCarrier !== '') {
            $query->where('carrier_id', $this->filterCarrier);
        }

        $rates = $query->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Calculate statistics
        $stats = (object) [
            'total' => Rate::count(),
            'ativos' => Rate::where('ativo', true)->count(),
            'inativos' => Rate::where('ativo', false)->count(),
            'carriers' => Rate::distinct('carrier_id')->count('carrier_id'),
        ];

        return view('livewire.rates.index', [
            'rates' => $rates,
            'stats' => $stats,
            'carriers' => $this->getCarriers(),
            'tarifas' => $this->getTarifas(),
        ]);
    }

    public function openFilterModal()
    {
        $this->filterModal = true;
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterTarifa = '';
        $this->filterCarrier = '';
        $this->search = '';
    }

    public function getCarriers()
    {
        return Carrier::where('ativo', true)
            ->orderBy('operadora')
            ->get()
            ->map(function($carrier) {
                return [
                    'value' => $carrier->id,
                    'label' => $carrier->operadora,
                ];
            })
            ->toArray();
    }

    public function getTarifas()
    {
        return Rate::select('tarifa')
            ->distinct()
            ->whereNotNull('tarifa')
            ->orderBy('tarifa')
            ->pluck('tarifa')
            ->toArray();
    }
}
