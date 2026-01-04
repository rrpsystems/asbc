<?php

namespace App\Livewire\Resellers;

use App\Models\Reseller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reports extends Component
{
    public $reseller;
    public $month;
    public $year;
    public $reportType = 'summary'; // summary, by_customer, by_date

    public function mount()
    {
        $user = Auth::user();

        if (!$user->reseller_id) {
            abort(403, 'Usuário não está associado a uma revenda');
        }

        $this->reseller = Reseller::findOrFail($user->reseller_id);
        $this->month = now()->month;
        $this->year = now()->year;
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
    }

    public function render()
    {
        $startDate = \Carbon\Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth();

        $data = [];

        if ($this->reportType === 'summary') {
            $data = $this->getSummaryReport($startDate, $endDate);
        } elseif ($this->reportType === 'by_customer') {
            $data = $this->getCustomerReport($startDate, $endDate);
        } elseif ($this->reportType === 'by_date') {
            $data = $this->getDateReport($startDate, $endDate);
        }

        return view('livewire.resellers.reports', $data);
    }

    private function getSummaryReport($startDate, $endDate)
    {
        // Chamadas do mês
        $chamadas = DB::table('cdrs')
            ->join('customers', 'cdrs.customer_id', '=', 'customers.id')
            ->where('customers.reseller_id', $this->reseller->id)
            ->whereBetween('cdrs.start', [$startDate, $endDate])
            ->where('cdrs.cobrada', true)
            ->select(
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(cdrs.billsec) as total_segundos'),
                DB::raw('SUM(cdrs.valor_venda) as custo_base'),
                DB::raw('SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda)) as receita_final'),
                DB::raw('SUM(COALESCE(cdrs.valor_markup, 0)) as lucro')
            )
            ->first();

        // Produtos do mês
        $produtos = DB::table('revenue_summaries')
            ->join('customers', 'revenue_summaries.customer_id', '=', 'customers.id')
            ->where('customers.reseller_id', $this->reseller->id)
            ->where('revenue_summaries.mes', $this->month)
            ->where('revenue_summaries.ano', $this->year)
            ->select(
                DB::raw('SUM(revenue_summaries.produtos_receita) as receita_base'),
                DB::raw('COUNT(DISTINCT revenue_summaries.customer_id) as total_clientes')
            )
            ->first();

        $produtos_receita_base = $produtos->receita_base ?? 0;
        $produtos_receita_final = 0;

        if ($produtos_receita_base > 0) {
            if ($this->reseller->valor_fixo_produtos) {
                $produtos_receita_final = $this->reseller->valor_fixo_produtos * ($produtos->total_clientes ?? 0);
            } else {
                $produtos_receita_final = $produtos_receita_base * (1 + $this->reseller->markup_produtos / 100);
            }
        }

        return [
            'summary' => [
                'chamadas' => [
                    'total' => $chamadas->total_chamadas ?? 0,
                    'minutos' => round(($chamadas->total_segundos ?? 0) / 60, 2),
                    'custo_base' => $chamadas->custo_base ?? 0,
                    'receita_final' => $chamadas->receita_final ?? 0,
                    'lucro' => $chamadas->lucro ?? 0,
                ],
                'produtos' => [
                    'custo_base' => $produtos_receita_base,
                    'receita_final' => $produtos_receita_final,
                    'lucro' => $produtos_receita_final - $produtos_receita_base,
                ],
                'total' => [
                    'custo_base' => ($chamadas->custo_base ?? 0) + $produtos_receita_base,
                    'receita_final' => ($chamadas->receita_final ?? 0) + $produtos_receita_final,
                    'lucro' => ($chamadas->lucro ?? 0) + ($produtos_receita_final - $produtos_receita_base),
                ],
            ],
        ];
    }

    private function getCustomerReport($startDate, $endDate)
    {
        $customerData = DB::table('customers')
            ->leftJoin('cdrs', function($join) use ($startDate, $endDate) {
                $join->on('cdrs.customer_id', '=', 'customers.id')
                    ->where('cdrs.cobrada', true)
                    ->whereBetween('cdrs.start', [$startDate, $endDate]);
            })
            ->leftJoin('revenue_summaries', function($join) {
                $join->on('revenue_summaries.customer_id', '=', 'customers.id')
                    ->where('revenue_summaries.mes', $this->month)
                    ->where('revenue_summaries.ano', $this->year);
            })
            ->where('customers.reseller_id', $this->reseller->id)
            ->select(
                'customers.id',
                'customers.razaosocial',
                'customers.ativo',
                DB::raw('COUNT(DISTINCT cdrs.id) as total_chamadas'),
                DB::raw('SUM(COALESCE(cdrs.billsec, 0)) as total_segundos'),
                DB::raw('SUM(COALESCE(cdrs.valor_venda, 0)) as chamadas_custo_base'),
                DB::raw('SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda, 0)) as chamadas_receita_final'),
                DB::raw('SUM(COALESCE(cdrs.valor_markup, 0)) as chamadas_lucro'),
                DB::raw('SUM(COALESCE(revenue_summaries.produtos_receita, 0)) as produtos_custo_base')
            )
            ->groupBy('customers.id', 'customers.razaosocial', 'customers.ativo')
            ->orderByDesc(DB::raw('SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda, 0)) + SUM(COALESCE(revenue_summaries.produtos_receita, 0))'))
            ->get()
            ->map(function ($customer) {
                // Calcula receita final de produtos
                if ($customer->produtos_custo_base > 0) {
                    if ($this->reseller->valor_fixo_produtos) {
                        $customer->produtos_receita_final = $this->reseller->valor_fixo_produtos;
                    } else {
                        $customer->produtos_receita_final = $customer->produtos_custo_base * (1 + $this->reseller->markup_produtos / 100);
                    }
                } else {
                    $customer->produtos_receita_final = 0;
                }

                $customer->produtos_lucro = $customer->produtos_receita_final - $customer->produtos_custo_base;
                $customer->total_custo_base = $customer->chamadas_custo_base + $customer->produtos_custo_base;
                $customer->total_receita_final = $customer->chamadas_receita_final + $customer->produtos_receita_final;
                $customer->total_lucro = $customer->chamadas_lucro + $customer->produtos_lucro;

                return $customer;
            });

        return [
            'customerData' => $customerData,
        ];
    }

    private function getDateReport($startDate, $endDate)
    {
        $dailyData = DB::table('cdrs')
            ->join('customers', 'cdrs.customer_id', '=', 'customers.id')
            ->where('customers.reseller_id', $this->reseller->id)
            ->whereBetween('cdrs.start', [$startDate, $endDate])
            ->where('cdrs.cobrada', true)
            ->select(
                DB::raw('DATE(cdrs.start) as data'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(cdrs.billsec) as total_segundos'),
                DB::raw('SUM(cdrs.valor_venda) as custo_base'),
                DB::raw('SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda)) as receita_final'),
                DB::raw('SUM(COALESCE(cdrs.valor_markup, 0)) as lucro')
            )
            ->groupBy(DB::raw('DATE(cdrs.start)'))
            ->orderBy('data', 'asc')
            ->get()
            ->map(function ($day) {
                $day->minutos = round($day->total_segundos / 60, 2);
                return $day;
            });

        return [
            'dailyData' => $dailyData,
        ];
    }
}
