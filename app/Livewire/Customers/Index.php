<?php

namespace App\Livewire\Customers;

use App\Livewire\Traits\Table;
use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    public $filterStatus = '';
    public $filterUf = '';
    public $filterBloqueio = '';
    public $filterModal = false;

    #[On('table-update')]
    public function render()
    {
        $query = Customer::query()
            ->where(function($q) {
                $q->where('razaosocial', 'like', '%'.$this->search.'%')
                  ->orWhere('nomefantasia', 'like', '%'.$this->search.'%')
                  ->orWhere('cnpj', 'like', '%'.$this->search.'%')
                  ->orWhere('cidade', 'like', '%'.$this->search.'%');
            });

        // Apply filters
        if ($this->filterStatus !== '') {
            $query->where('ativo', $this->filterStatus === '1');
        }

        if ($this->filterUf !== '') {
            $query->where('uf', $this->filterUf);
        }

        if ($this->filterBloqueio !== '') {
            if ($this->filterBloqueio === '1') {
                $query->where(function($q) {
                    $q->where('bloqueio_entrada', true)
                      ->orWhere('bloqueio_saida', true);
                });
            } else {
                $query->where('bloqueio_entrada', false)
                      ->where('bloqueio_saida', false);
            }
        }

        $customers = $query->with('reseller')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Calculate statistics
        $stats = (object) [
            'total' => Customer::count(),
            'ativos' => Customer::where('ativo', true)->count(),
            'inativos' => Customer::where('ativo', false)->count(),
            'bloqueados' => Customer::where(function($q) {
                $q->where('bloqueio_entrada', true)
                  ->orWhere('bloqueio_saida', true);
            })->count(),
        ];

        return view('livewire.customers.index', [
            'customers' => $customers,
            'stats' => $stats,
            'ufs' => $this->getUfs(),
        ]);
    }

    public function openFilterModal()
    {
        $this->filterModal = true;
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterUf = '';
        $this->filterBloqueio = '';
        $this->search = '';
    }

    public function getUfs()
    {
        return Customer::select('uf')
            ->distinct()
            ->whereNotNull('uf')
            ->where('uf', '!=', '')
            ->orderBy('uf')
            ->pluck('uf')
            ->toArray();
    }
}
