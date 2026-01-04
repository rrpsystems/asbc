<?php

namespace App\Livewire\Resellers;

use App\Models\Reseller;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.app')]
class Index extends Component
{
    use Interactions, WithPagination;

    public $search = '';
    public $filterAtivo = 'all'; // all, ativo, inativo

    protected $queryString = [
        'search' => ['except' => ''],
        'filterAtivo' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterAtivo()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $reseller = Reseller::findOrFail($id);

            // Verifica se tem clientes associados
            if ($reseller->customers()->count() > 0) {
                $this->toast()
                    ->error('Não é possível excluir', 'Esta revenda possui ' . $reseller->customers()->count() . ' cliente(s) associado(s).')
                    ->send();
                return;
            }

            $reseller->delete();

            $this->toast()->success('Revenda excluída com sucesso!')->send();
        } catch (\Exception $e) {
            $this->toast()->error('Erro ao excluir revenda: ' . $e->getMessage())->send();
        }
    }

    public function toggleAtivo($id)
    {
        try {
            $reseller = Reseller::findOrFail($id);
            $reseller->update(['ativo' => !$reseller->ativo]);

            $message = $reseller->ativo ? 'Revenda ativada!' : 'Revenda desativada!';
            $this->toast()->success($message)->send();
        } catch (\Exception $e) {
            $this->toast()->error('Erro ao alterar status: ' . $e->getMessage())->send();
        }
    }

    public function render()
    {
        $query = Reseller::query()
            ->withCount(['customers', 'customers as active_customers_count' => function ($q) {
                $q->where('ativo', true);
            }]);

        // Filtro de busca
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nome', 'ilike', '%' . $this->search . '%')
                  ->orWhere('razao_social', 'ilike', '%' . $this->search . '%')
                  ->orWhere('email', 'ilike', '%' . $this->search . '%')
                  ->orWhere('cnpj', 'ilike', '%' . $this->search . '%');
            });
        }

        // Filtro de status
        if ($this->filterAtivo === 'ativo') {
            $query->where('ativo', true);
        } elseif ($this->filterAtivo === 'inativo') {
            $query->where('ativo', false);
        }

        $resellers = $query->orderBy('nome')->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Reseller::count(),
            'ativos' => Reseller::where('ativo', true)->count(),
            'inativos' => Reseller::where('ativo', false)->count(),
            'total_clientes' => Reseller::withCount('customers')->get()->sum('customers_count'),
        ];

        return view('livewire.resellers.index', [
            'resellers' => $resellers,
            'stats' => $stats,
        ]);
    }
}
