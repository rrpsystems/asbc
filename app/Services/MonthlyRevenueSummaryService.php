<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\RevenueSummary;

class MonthlyRevenueSummaryService
{
    public function atualizarResumo($cdr)
    {
        // Busca os dados do customer
        $customer = Customer::find($cdr->customer_id);

        // Encontra ou cria o resumo para o mês e ano do CDR
        $resumo = RevenueSummary::firstOrCreate(
            [
                'customer_id' => $cdr->customer_id,
                'mes' => $cdr->calldate->month,
                'ano' => $cdr->calldate->year,
            ],
            [
                'valor_plano' => 0, // Valor inicial do plano
                'minutos_usados' => 0,
                'minutos_excedentes' => 0,
                'custo_total' => 0,
                'franquia_minutos' => $customer->franquia_minutos, //1000 // Exemplo, pode vir do plano do cliente
                'valor_plano' => $customer->valor_plano, //1000 // Exemplo, pode vir do plano do cliente
            ]
            //'minutos_fixo')->default(0);
            //'minutos_movel')->default(0);
            //'minutos_internacional')->default(0);
            //'minutos_usados'); // Minutos utilizados no mês
            //'minutos_excedentes')->default(0); // Minutos que excederam a franquia

            //'excedente_fixo', 10, 2)->default(0.00);
            //'excedente_movel', 10, 2)->default(0.00);
            //'excedente_internal', 10, 2)->default(0.00);

            //'excedente_total', 10, 2)->default(0.00);
            //'custo_excedente', 10, 2)->default(0); // Custo do uso excedente
            //'custo_total', 10, 2); // Custo total do cliente no mês (incluindo excedente)
        );

        // Atualiza o resumo com base no tipo de chamada (fixo, móvel, etc.)
        switch ($cdr->tarifa) {
            case 'Fixo':
                $resumo->minutos_fixo += $cdr->tempo_cobrado;
                break;
            case 'Movel':
                $resumo->minutos_movel += $cdr->tempo_cobrado;
                break;
            case 'Internacional':
                $resumo->minutos_internacional += $cdr->tempo_cobrado;
                break;
        }

        // Atualiza os minutos totais usados
        $resumo->minutos_usados += $cdr->tempo_cobrado;

        // Calcula se houve excedente
        $excedente = max(0, $resumo->minutos_usados - $resumo->franquia_minutos);
        $resumo->minutos_excedentes = $excedente;

        // Atualiza o custo total do excedente
        $resumo->custo_excedente = $this->calcularCustoExcedente($cdr, $resumo);
        $resumo->custo_total = $resumo->valor_plano + $resumo->custo_excedente;

        $resumo->save();
    }

    protected function calcularCustoExcedente($cdr, $resumo)
    {
        // Baseia-se nos minutos excedentes e tarifas para calcular o custo
        return $resumo->minutos_excedentes * $cdr->valor_venda;
    }
}
