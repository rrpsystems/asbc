<?php

namespace App\Livewire\Reports;

use App\Models\Customer;
use App\Models\RevenueSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RevenueForecast extends Component
{
    public $mes;
    public $ano;
    public $selectedCustomerId;
    public $detailsModal = false;
    public $customerDetails;

    public function mount()
    {
        $this->mes = Carbon::now()->month;
        $this->ano = Carbon::now()->year;
    }

    public function openDetails($customerId)
    {
        $this->selectedCustomerId = $customerId;
        $customer = Customer::find($customerId);

        // Dados do mês atual
        $currentMonth = RevenueSummary::where('customer_id', $customerId)
            ->where('mes', $this->mes)
            ->where('ano', $this->ano)
            ->first();

        // Dados dos últimos 3 meses para média
        $lastMonths = RevenueSummary::where('customer_id', $customerId)
            ->where(function ($query) {
                $date = Carbon::create($this->ano, $this->mes, 1)->subMonths(3);
                $query->where('ano', '>', $date->year)
                    ->orWhere(function ($q) use ($date) {
                        $q->where('ano', $date->year)
                            ->where('mes', '>=', $date->month);
                    });
            })
            ->where(function ($query) {
                $query->where('ano', '<', $this->ano)
                    ->orWhere(function ($q) {
                        $q->where('ano', $this->ano)
                            ->where('mes', '<', $this->mes);
                    });
            })
            ->orderBy('ano', 'DESC')
            ->orderBy('mes', 'DESC')
            ->limit(3)
            ->get();

        $this->customerDetails = [
            'customer' => $customer,
            'current' => $currentMonth,
            'history' => $lastMonths,
            'avg_receita' => $lastMonths->avg('custo_total'),
            'avg_minutos' => $lastMonths->avg('minutos_total'),
        ];

        $this->detailsModal = true;
    }

    public function render()
    {
        $hoje = Carbon::now();
        $diasNoMes = Carbon::create($this->ano, $this->mes, 1)->daysInMonth;
        $diaAtual = $hoje->day;

        // Se não é o mês atual, usa o último dia do mês
        if ($this->mes != $hoje->month || $this->ano != $hoje->year) {
            $diaAtual = $diasNoMes;
        }

        $percentualMesDecorrido = ($diaAtual / $diasNoMes) * 100;

        // Busca dados do mês selecionado com projeção
        $forecasts = RevenueSummary::query()
            ->select([
                'revenue_summaries.*',
                'customers.razaosocial',
                'customers.nomefantasia',
                DB::raw('COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) as receita_atual'),
                // Projeção: (Receita Atual / Dias Decorridos) * Dias no Mês
                DB::raw("CASE
                    WHEN {$diaAtual} > 0 THEN
                        (COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) / {$diaAtual}) * {$diasNoMes}
                    ELSE 0
                END as receita_projetada"),
                DB::raw("CASE
                    WHEN {$diaAtual} > 0 THEN
                        (revenue_summaries.minutos_total / {$diaAtual}) * {$diasNoMes}
                    ELSE 0
                END as minutos_projetados"),
                DB::raw("CASE
                    WHEN revenue_summaries.franquia_minutos > 0 THEN
                        ((revenue_summaries.minutos_total / {$diaAtual}) * {$diasNoMes} / revenue_summaries.franquia_minutos) * 100
                    ELSE 0
                END as previsao_uso_franquia"),
            ])
            ->join('customers', 'revenue_summaries.customer_id', '=', 'customers.id')
            ->where('revenue_summaries.mes', $this->mes)
            ->where('revenue_summaries.ano', $this->ano)
            ->where('customers.ativo', true)
            ->orderBy('receita_projetada', 'DESC')
            ->get();

        // Totais
        $totals = (object) [
            'receita_atual' => $forecasts->sum('receita_atual'),
            'receita_projetada' => $forecasts->sum('receita_projetada'),
            'minutos_atuais' => $forecasts->sum('minutos_total'),
            'minutos_projetados' => $forecasts->sum('minutos_projetados'),
            'clientes_risco' => $forecasts->where('previsao_uso_franquia', '>', 100)->count(),
        ];

        return view('livewire.reports.revenue-forecast', compact('forecasts', 'totals', 'percentualMesDecorrido', 'diaAtual', 'diasNoMes'));
    }
}
