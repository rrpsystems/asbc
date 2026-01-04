<?php

namespace App\Livewire\Invoices;

use App\Livewire\Traits\Table;
use App\Models\Customer;
use App\Models\RevenueSummary;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class CustomerInvoices extends Component
{
    use Table;

    public $customerId;
    public $customer;

    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $this->customer = Customer::findOrFail($customerId);
    }

    public function openDetails($id)
    {
        redirect()->route('report.invoice.details', $id);
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        // Limpa cache das estatísticas deste cliente
        Cache::forget("invoices:customer_stats:{$this->customerId}");

        // Força re-renderização
        $this->render();
    }

    #[On('table-update')]
    public function render()
    {
        $this->direction = 'desc';
        $invoices = RevenueSummary::where('customer_id', $this->customerId)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        // Estatísticas do cliente consolidadas em uma única query (cache de 15 minutos)
        $stats = Cache::remember("invoices:customer_stats:{$this->customerId}", now()->addMinutes(15), function () {
            return RevenueSummary::where('customer_id', $this->customerId)
                ->selectRaw('
                    COUNT(*) as total_faturas,
                    COUNT(CASE WHEN fechado = false THEN 1 END) as faturas_abertas,
                    COUNT(CASE WHEN fechado = true THEN 1 END) as faturas_fechadas,
                    COALESCE(SUM(CASE WHEN fechado = true THEN custo_total ELSE 0 END), 0) as receita_total
                ')
                ->first();
        });

        $totalFaturas = $stats->total_faturas;
        $faturasAbertas = $stats->faturas_abertas;
        $faturasFechadas = $stats->faturas_fechadas;
        $receitaTotal = $stats->receita_total;
        $mediaFatura = $faturasFechadas > 0 ? $receitaTotal / $faturasFechadas : 0;

        return view('livewire.invoices.customer-invoices', compact('invoices', 'totalFaturas', 'faturasAbertas', 'faturasFechadas', 'receitaTotal', 'mediaFatura'));
    }
}
