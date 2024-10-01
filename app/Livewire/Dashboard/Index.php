<?php

namespace App\Livewire\Dashboard;

use App\Models\Cdr;
use App\Models\Rate;
use Livewire\Component;

class Index extends Component
{
    public $data;

    public $data1;

    public $data2;

    public $teste;

    public $tempo;

    public $valor;

    protected function calcularTarifa($cdr)
    {
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

        if ($rate->venda == 0) {
            $tempoCobrado = 0;
        } else {
            // Calcula o tempo cobrado com base no tempoinicial, tempominimo, e incremento
            $tempoCobrado = $this->calcularTempoCobrado($cdr->billsec, $rate->tempoinicial, $rate->tempominimo, $rate->incremento);
        }

        // Calcula os valores de compra e venda
        $valorCompra = $this->calcularValor($tempoCobrado, $rate->compra, $rate->vconexao);
        $valorVenda = $this->calcularValor($tempoCobrado, $rate->venda, $rate->vconexao);

        return [
            'compra' => $valorCompra,
            'venda' => $valorVenda,
        ];
    }

    protected function calcularValor($tempoCobrado, $valorTarifa, $valorConexao)
    {
        // O valor total inclui a conexão e o tempo tarifado
        return ($tempoCobrado * ($valorTarifa / 60)) + $valorConexao;
    }

    protected function calcularTempoCobrado($tempoFalado, $tempoinicial, $tempominimo, $incremento)
    {
        // Ajusta o tempo inicial se for maior que o falado
        if ($tempoFalado <= $tempoinicial) {
            return 0;
        }

        // Ajusta para o tempo mínimo
        if ($tempoFalado < $tempominimo) {
            return $tempominimo;
        }

        // Calcula o tempo com base no incremento
        $tempoExtra = $tempoFalado - $tempominimo;
        $incrementos = ceil($tempoExtra / $incremento);

        return $tempominimo + ($incrementos * $incremento);
    }

    protected function maxCustomerChannels($date)
    {
        $results = Cdr::with('customer')->selectRaw('customer_id, MAX(customer_channels) as max_customer_channels')
            ->whereDate('calldate', $date)
            ->groupBy('customer_id')
            ->orderBy('max_customer_channels', 'desc')
            ->get();

        return $results;
    }

    protected function maxCalls($date)
    {
        $results = Cdr::with('customer')->selectRaw('customer_id, COUNT(customer_id) as max_customer_calls, SUM(billsec) as total_billsec')
            ->whereDate('calldate', $date)
            ->groupBy('customer_id')
            ->orderBy('max_customer_calls', 'desc')
            ->get();

        return $results;
    }

    protected function maxChannels($date)
    {

        $results = Cdr::selectRaw('DATE_TRUNC(\'hour\', calldate) as hour, MAX(carrier_channels) as max_carrier_channels, MAX(customer_channels) as max_customer_channels')
            ->whereDate('calldate', $date)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return $results;
    }

    public function render()
    {

        $this->data = $this->maxChannels('2024-09-30');
        $this->data1 = $this->maxCustomerChannels('2024-09-30');
        $this->data2 = $this->maxCalls('2024-09-30');
        // dd($this->data2);
        //dd($this->data);
        //dd($this->calcularTarifa(Cdr::where('tarifa', 'Movel')->orderBy('billsec', 'desc')->first()));
        //$this->teste = $this->calcularValor(1, 1, 1);
        $this->tempo = $this->calcularTempoCobrado(55, 0, 30, 6);
        $this->valor = $this->calcularValor($this->tempo, 1.00, 0.00);

        return view('livewire.dashboard.index');
    }
}
