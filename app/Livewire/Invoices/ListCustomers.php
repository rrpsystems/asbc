<?php

namespace App\Livewire\Invoices;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListCustomers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 8;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        // Limpa todos os caches do relatório de faturas
        Cache::forget('invoices:stats');
        Cache::forget('invoices:total_clientes');

        // Força re-renderização
        $this->render();
    }

    public function render()
    {
        // Lista de clientes com suas faturas (cache de 10 minutos)
        $customers = Customer::where('ativo', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nomefantasia', 'ilike', '%' . $this->search . '%')
                      ->orWhere('razaosocial', 'ilike', '%' . $this->search . '%');
                });
            })
            ->withCount(['revenueSummaries as faturas_count'])
            ->with(['revenueSummaries' => function ($query) {
                $query->orderByDesc('ano')->orderByDesc('mes')->limit(1);
            }])
            ->paginate($this->perPage);

        // Total de clientes ativos (cache de 30 minutos - muda raramente)
        $totalClientes = Cache::remember('invoices:total_clientes', now()->addMinutes(30), function () {
            return Customer::where('ativo', true)->count();
        });

        // Estatísticas consolidadas em uma única query (cache de 15 minutos)
        $stats = Cache::remember('invoices:stats', now()->addMinutes(15), function () {
            return \App\Models\RevenueSummary::selectRaw('
                COUNT(*) as total_faturas,
                COUNT(CASE WHEN fechado = false THEN 1 END) as faturas_abertas,
                COUNT(CASE WHEN fechado = true THEN 1 END) as faturas_fechadas,
                COALESCE(SUM(CASE WHEN fechado = true THEN custo_total ELSE 0 END), 0) as receita_total
            ')->first();
        });

        return view('livewire.invoices.list-customers', [
            'customers' => $customers,
            'totalClientes' => $totalClientes,
            'totalFaturas' => $stats->total_faturas,
            'faturasAbertas' => $stats->faturas_abertas,
            'faturasFechadas' => $stats->faturas_fechadas,
            'receitaTotal' => $stats->receita_total,
        ]);
    }
}
