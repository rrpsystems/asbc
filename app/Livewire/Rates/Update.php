<?php

namespace App\Livewire\Rates;

use App\Enums\TipoTarifa;
use App\Models\Carrier;
use App\Models\Rate;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions;

    public $rate;

    public $carriers; // Para armazenar a lista de carriers

    public $carrier_id; // ID da carrier selecionada

    public $tarifas; // Para armazenar a lista de tarifas

    public $tarifa_id;

    public $prefixo;

    public $descricao;

    public $tempoinicial = 3;

    public $tempominimo = 30;

    public $incremento = 6;

    public $compra = 0;

    public $venda = 0;

    public $vconexao = 0;

    public $ativo = true;

    public $slide = false;

    public function mount()
    {
        // Popula o array de tarifas usando a enum
        $this->tarifas = TipoTarifa::options();

        $this->carriers = Carrier::all()->map(function ($carrier) {
            return [
                'label' => $carrier->operadora,
                'value' => $carrier->id,
                'description' => $carrier->id,
            ];
        })->toArray();
    }

    #[On('rate-update')]
    public function edit($id)
    {

        //dd($this->tarifas);

        $this->rate = Rate::find($id);

        $this->carrier_id = $this->rate->carrier_id;
        $this->tarifa_id = $this->rate->tarifa;
        $this->prefixo = $this->rate->prefixo;
        $this->descricao = $this->rate->descricao;
        $this->tempoinicial = $this->rate->tempoinicial;
        $this->tempominimo = $this->rate->tempominimo;
        $this->incremento = $this->rate->incremento;
        $this->compra = $this->rate->compra;
        $this->venda = $this->rate->venda;
        $this->vconexao = $this->rate->vconexao;
        $this->ativo = $this->rate->ativo;
        $this->slide = true;
        //$this->dispatch('update-open');
    }

    public function update()
    {
        $this->validate([
            'prefixo' => 'nullable|numeric',
            //'descricao' => 'required|string|min:3',
            'tarifa_id' => 'required',
            'carrier_id' => 'required',
            'venda' => 'required|numeric',
            'compra' => 'required|numeric',
            'vconexao' => 'required|numeric',
            'tempoinicial' => 'required|numeric',
            'tempominimo' => 'required|numeric',
            'incremento' => 'required|numeric',
            'carrier_id' => 'required',
            'descricao' => ['required', 'string', 'min:3',
                function ($attribute, $value, $fail) {
                    $exists = Rate::where('id', '!=', $this->rate->id)
                        ->where('tarifa', $this->tarifa_id)
                        ->where('carrier_id', $this->carrier_id)
                        ->where('prefixo', $this->prefixo)
                        ->first();

                    if ($exists) {
                        $fail('Esta combinação de tarifa, prefixo e operadora já existe!');
                    }
                },
            ],
        ]);

        $data = [
            'prefixo' => $this->prefixo,
            'tarifa' => $this->tarifa_id,
            'carrier_id' => $this->carrier_id,
            'descricao' => $this->descricao,
            'tempoinicial' => $this->tempoinicial,
            'tempominimo' => $this->tempominimo,
            'incremento' => $this->incremento,
            'compra' => $this->compra,
            'venda' => $this->venda,
            'vconexao' => $this->vconexao,
            'ativo' => $this->ativo,
        ];

        try {
            $this->rate->update($data);
        } catch (\Exception $e) {
            $this->dispatch('table-update');
            $this->toast()->error('Erro ao alterar a Tarifa!')->send();

            return;
        }

        $this->cancel();
        $this->toast()->success('Tarifa alterada com sucesso!')->send();
    }

    public function cancel()
    {
        $this->dispatch('table-update');
        $this->resetValidation();
        $this->reset(['prefixo', 'carrier_id', 'tarifa_id', 'descricao', 'tempoinicial', 'tempominimo',
            'incremento', 'compra', 'venda', 'vconexao', 'ativo', ]);
        $this->slide = false;
    }

    public function render()
    {
        return view('livewire.rates.update');
    }
}
