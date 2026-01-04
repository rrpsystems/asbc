<?php

namespace App\Livewire\Resellers;

use App\Models\Customer;
use App\Models\Reseller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $reseller;
    public $search = '';
    public $perPage = 10;
    public $sort = 'razaosocial';
    public $direction = 'asc';
    public $filterAtivo = 'all';

    protected $queryString = ['search', 'sort', 'direction', 'filterAtivo'];

    public function mount()
    {
        $user = Auth::user();

        if (!$user->reseller_id) {
            abort(403, 'Usuário não está associado a uma revenda');
        }

        $this->reseller = Reseller::findOrFail($user->reseller_id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterAtivo()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }

    public function render()
    {
        $query = Customer::where('reseller_id', $this->reseller->id);

        // Filtro de busca
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('razaosocial', 'ilike', '%' . $this->search . '%')
                    ->orWhere('cnpj', 'ilike', '%' . $this->search . '%')
                    ->orWhere('email', 'ilike', '%' . $this->search . '%');
            });
        }

        // Filtro de status
        if ($this->filterAtivo === 'active') {
            $query->where('ativo', true);
        } elseif ($this->filterAtivo === 'inactive') {
            $query->where('ativo', false);
        }

        $customers = $query->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Estatísticas
        $stats = [
            'total' => Customer::where('reseller_id', $this->reseller->id)->count(),
            'ativos' => Customer::where('reseller_id', $this->reseller->id)->where('ativo', true)->count(),
            'inativos' => Customer::where('reseller_id', $this->reseller->id)->where('ativo', false)->count(),
        ];

        return view('livewire.resellers.customers', [
            'customers' => $customers,
            'stats' => $stats,
        ]);
    }
}
