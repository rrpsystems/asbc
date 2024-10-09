<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\RevenueSummary;
use Carbon\Carbon;

class MonthlyRevenueSummaryService
{
    public function atualizarResumo($cdr)
    {
        // Busca os dados do customer
        //$customer = Customer::find($cdr->customer_id);

        // Encontra ou cria o resumo para o mês e ano do CDR
        $resumo = RevenueSummary::firstOrCreate(
            [
                'customer_id' => $cdr->customer_id,
                'mes' => Carbon::parse($cdr->calldate)->month,
                'ano' => Carbon::parse($cdr->calldate)->year,
            ],
            [
                'franquia_minutos' => $cdr->customer->franquia_minutos,
                'valor_plano' => $cdr->customer->valor_plano,
                'minutos_usados' => 0,
                'custo_total' => $cdr->customer->valor_plano,
            ]
        );

        // Atualiza o resumo com base no tipo de chamada
        switch ($cdr->tarifa) {
            case 'Fixo':
                $this->calcularFixo($cdr, $resumo);
                break;
            case 'Movel':
                $this->calcularMovel($cdr, $resumo);
                break;
            case 'Internacional':
                $this->calcularInternacional($cdr, $resumo);
                break;
            default:
                // Opcional: logar ou tratar chamadas de tarifa não reconhecidas
                return;
                break;
        }

        $resumo->save();
    }

    protected function calcularFixo($cdr, $resumo)
    {
        $this->atualizarResumoPorTipo($cdr, $resumo, 'fixo');
    }

    protected function calcularMovel($cdr, $resumo)
    {
        $this->atualizarResumoPorTipo($cdr, $resumo, 'movel');
    }

    protected function calcularInternacional($cdr, $resumo)
    {
        $resumo->minutos_excedentes_internacional += $cdr->tempo_cobrado;
        $resumo->minutos_excedentes += $cdr->tempo_cobrado;
        $resumo->excedente_internacional += $cdr->valor_venda;
        $resumo->custo_excedente += $cdr->valor_venda;
        $resumo->custo_total += $cdr->valor_venda;
        $resumo->minutos_total += $cdr->tempo_cobrado;
    }

    protected function atualizarResumoPorTipo($cdr, $resumo, $tipo)
    {
        $tempoCobrado = $cdr->tempo_cobrado;
        $valorVenda = $cdr->valor_venda;

        if ($this->controleMinutos($resumo)) {
            // Se não ultrapassou a franquia
            $resumo->{'minutos_'.$tipo} += $tempoCobrado;
            $resumo->minutos_usados += $tempoCobrado;
        } else {
            // Se ultrapassou a franquia
            $resumo->{'minutos_excedentes_'.$tipo} += $tempoCobrado;
            $resumo->minutos_excedentes += $tempoCobrado;
            $resumo->{'excedente_'.$tipo} += $valorVenda;
            $resumo->custo_excedente += $valorVenda;
            $resumo->custo_total += $valorVenda;
        }

        $resumo->minutos_total += $tempoCobrado;
    }

    protected function controleMinutos($resumo)
    {
        // Retorna true se a franquia foi ultrapassada
        return $resumo->minutos_usados > $resumo->franquia_minutos;
    }
}
