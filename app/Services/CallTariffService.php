<?php

namespace App\Services;

use App\Models\Rate;

class CallTariffService
{
    public function calcularTarifa($cdr)
    {
        if (! $cdr) {
            return null;
        }
        // Busca a tarifa com base no prefixo, operadora (carrier_id) e tipo de chamada (tarifa)
        $rate = Rate::where(function ($query) use ($cdr) {
            $query->whereRaw('? LIKE prefixo || \'%\'', [$cdr->numero])
                ->orWhereNull('prefixo');
        })
            ->where('carrier_id', $cdr->carrier_id)
            ->where('tarifa', $cdr->tarifa)
            ->where('ativo', true)
            ->orderByRaw('LENGTH(prefixo) DESC NULLS LAST')
            ->first();

        if (! $rate) {
            //$rate->status = 'Erro';
            throw new \Exception('Tarifa não encontrada para a chamada.');
        }

        // Calcula o tempo cobrado com base no tempoinicial, tempominimo, e incremento
        $tempoCobrado = $this->calcularTempoCobrado($cdr->billsec, $rate);
        // Calcula os valores de compra e venda
        $valorCompra = $this->calcularValor($tempoCobrado, $rate->compra, $rate->vconexao);
        $valorVenda = $this->calcularValor($tempoCobrado, $rate->venda, $rate->vconexao);

        return [
            'compra' => $valorCompra,
            'venda' => $valorVenda,
            'tempo_cobrado' => $tempoCobrado,
        ];
    }

    protected function calcularTempoCobrado($tempoFalado, $rate)
    {
        // Ajusta se o valor da tarifa for zero retorna 0
        if ($rate->venda == 0) {
            return 0;
        }

        // Ajusta o tempo inicial se for menor que o falado
        if ($tempoFalado <= $rate->tempoinicial) {
            return 0;
        }

        // Ajusta para o tempo mínimo
        if ($tempoFalado < $rate->tempominimo) {
            return $rate->tempominimo;
        }

        // Calcula o tempo com base no incremento
        $tempoExtra = $tempoFalado - $rate->tempominimo;
        $incrementos = ceil($tempoExtra / $rate->incremento);

        return $rate->tempominimo + ($incrementos * $rate->incremento);
    }

    protected function calcularValor($tempoCobrado, $valorTarifa, $valorConexao)
    {
        // O valor total inclui a conexão e o tempo tarifado
        return ($tempoCobrado * ($valorTarifa / 60)) + $valorConexao;
    }
}
