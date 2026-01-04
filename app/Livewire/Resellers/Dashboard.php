<?php

namespace App\Livewire\Resellers;

use App\Models\Reseller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $reseller;
    public $month;
    public $year;

    // Estatísticas
    public $totalClientes;
    public $clientesAtivos;
    public $totalAPagar;
    public $totalAReceber;
    public $lucroTotal;

    // Estatísticas do mês
    public $chamadas_mes;
    public $minutos_mes;
    public $receita_chamadas_base;
    public $receita_chamadas_final;
    public $receita_produtos_base;
    public $receita_produtos_final;
    public $lucro_mes;

    public function mount()
    {
        $user = Auth::user();

        if (!$user->reseller_id) {
            abort(403, 'Usuário não está associado a uma revenda');
        }

        $this->reseller = Reseller::findOrFail($user->reseller_id);
        $this->month = now()->month;
        $this->year = now()->year;

        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        // Total de clientes
        $this->totalClientes = Customer::where('reseller_id', $this->reseller->id)->count();
        $this->clientesAtivos = Customer::where('reseller_id', $this->reseller->id)
            ->where('ativo', true)
            ->count();

        // Estatísticas do mês atual
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        // Chamadas do mês
        $chamadas = DB::table('cdrs')
            ->join('customers', 'cdrs.customer_id', '=', 'customers.id')
            ->where('customers.reseller_id', $this->reseller->id)
            ->whereBetween('cdrs.start', [$startDate, $endDate])
            ->where('cdrs.cobrada', true)
            ->select(
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(cdrs.billsec) as total_segundos'),
                DB::raw('SUM(cdrs.valor_venda) as receita_base'),
                DB::raw('SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda)) as receita_final'),
                DB::raw('SUM(COALESCE(cdrs.valor_markup, 0)) as lucro')
            )
            ->first();

        $this->chamadas_mes = $chamadas->total_chamadas ?? 0;
        $this->minutos_mes = round(($chamadas->total_segundos ?? 0) / 60, 2);
        $this->receita_chamadas_base = $chamadas->receita_base ?? 0;
        $this->receita_chamadas_final = $chamadas->receita_final ?? 0;

        // Produtos e serviços do mês
        $produtos = DB::table('revenue_summaries')
            ->join('customers', 'revenue_summaries.customer_id', '=', 'customers.id')
            ->where('customers.reseller_id', $this->reseller->id)
            ->where('revenue_summaries.mes', $this->month)
            ->where('revenue_summaries.ano', $this->year)
            ->select(
                DB::raw('SUM(revenue_summaries.produtos_receita) as receita_base')
            )
            ->first();

        $this->receita_produtos_base = $produtos->receita_base ?? 0;

        // Calcula receita final de produtos com markup
        if ($this->receita_produtos_base > 0) {
            if ($this->reseller->valor_fixo_produtos) {
                $this->receita_produtos_final = $this->reseller->valor_fixo_produtos * $this->totalClientes;
            } else {
                $this->receita_produtos_final = $this->receita_produtos_base * (1 + $this->reseller->markup_produtos / 100);
            }
        } else {
            $this->receita_produtos_final = 0;
        }

        // Total a pagar (para o provider)
        $this->totalAPagar = $this->receita_chamadas_base + $this->receita_produtos_base;

        // Total a receber (dos clientes)
        $this->totalAReceber = $this->receita_chamadas_final + $this->receita_produtos_final;

        // Lucro total
        $this->lucro_mes = ($chamadas->lucro ?? 0) + ($this->receita_produtos_final - $this->receita_produtos_base);
        $this->lucroTotal = $this->totalAReceber - $this->totalAPagar;
    }

    public function changeMonth($direction)
    {
        if ($direction === 'prev') {
            $this->month--;
            if ($this->month < 1) {
                $this->month = 12;
                $this->year--;
            }
        } else {
            $this->month++;
            if ($this->month > 12) {
                $this->month = 1;
                $this->year++;
            }
        }

        $this->loadStatistics();
    }

    public function render()
    {
        // Top 5 clientes do mês (por faturamento)
        $topClientes = DB::table('customers')
            ->leftJoin('cdrs', function($join) {
                $join->on('cdrs.customer_id', '=', 'customers.id')
                    ->where('cdrs.cobrada', true)
                    ->whereBetween('cdrs.start', [
                        now()->setMonth($this->month)->setYear($this->year)->startOfMonth(),
                        now()->setMonth($this->month)->setYear($this->year)->endOfMonth()
                    ]);
            })
            ->where('customers.reseller_id', $this->reseller->id)
            ->select(
                'customers.id',
                'customers.razaosocial',
                DB::raw('COUNT(cdrs.id) as total_chamadas'),
                DB::raw('SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda)) as receita_total')
            )
            ->groupBy('customers.id', 'customers.razaosocial')
            ->orderByDesc('receita_total')
            ->limit(5)
            ->get();

        return view('livewire.resellers.dashboard', [
            'topClientes' => $topClientes,
        ]);
    }
}
