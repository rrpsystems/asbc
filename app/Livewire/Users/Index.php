<?php

namespace App\Livewire\Users;

use App\Enums\UserRole;
use App\Livewire\Traits\Table;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    public $filterRole = '';
    public $filterStatus = '';
    public $filterModal = false;

    public function openFilterModal()
    {
        $this->filterModal = true;
    }

    public function closeFilterModal()
    {
        $this->filterModal = false;
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filterModal = false;
    }

    public function clearFilters()
    {
        $this->filterRole = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function getRoles()
    {
        return collect(UserRole::cases())->map(function($role) {
            return [
                'value' => $role->value,
                'label' => $role->label(),
            ];
        })->toArray();
    }

    #[On('table-update')]
    public function render()
    {
        $query = User::with('customer')
            ->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            });

        // Aplicar filtros
        if ($this->filterRole !== '') {
            $query->where('rule', $this->filterRole);
        }

        if ($this->filterStatus !== '') {
            $query->where('ativo', $this->filterStatus === '1');
        }

        $users = $query->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Estatísticas
        $stats = (object) [
            'total' => User::count(),
            'ativos' => User::where('ativo', true)->count(),
            'inativos' => User::where('ativo', false)->count(),
            'admins' => User::where('rule', 'admin')->count(),
        ];

        return view('livewire.users.index', [
            'users' => $users,
            'stats' => $stats,
            'roles' => $this->getRoles(),
        ]);
    }
}
