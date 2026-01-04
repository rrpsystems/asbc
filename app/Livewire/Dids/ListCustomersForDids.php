<?php

namespace App\Livewire\Dids;

use App\Models\Customer;
use App\Models\Did;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListCustomersForDids extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $filterStatus = '';
    public $filterUf = '';
    public $filterModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function openFilterModal()
    {
        $this->filterModal = true;
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterUf = '';
        $this->search = '';
        $this->resetPage();
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

    public function render()
    {
        $query = Customer::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nomefantasia', 'ilike', '%' . $this->search . '%')
                      ->orWhere('razaosocial', 'ilike', '%' . $this->search . '%')
                      ->orWhere('cnpj', 'ilike', '%' . $this->search . '%');
                });
            });

        // Apply filters
        if ($this->filterStatus !== '') {
            $query->where('ativo', $this->filterStatus === '1');
        }

        if ($this->filterUf !== '') {
            $query->where('uf', $this->filterUf);
        }

        $customers = $query
            ->withCount(['dids', 'dids as dids_ativos_count' => function ($query) {
                $query->where('ativo', true);
            }])
            ->orderBy('nomefantasia')
            ->paginate($this->perPage);

        // Calculate statistics
        $stats = (object) [
            'total_clientes' => Customer::where('ativo', true)->count(),
            'total_dids' => Did::count(),
            'dids_ativos' => Did::where('ativo', true)->count(),
            'dids_inativos' => Did::where('ativo', false)->count(),
        ];

        return view('livewire.dids.list-customers-for-dids', [
            'customers' => $customers,
            'stats' => $stats,
            'ufs' => $this->getUfs(),
        ]);
    }
}
