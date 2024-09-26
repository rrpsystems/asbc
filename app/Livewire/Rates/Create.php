<?php

namespace App\Livewire\Rates;

use App\Enums\TipoTarifa;
use App\Models\Carrier;
use App\Models\Rate;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

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
        $this->compra = number_format($this->compra, 3, '.', ' ');
        $this->venda = number_format($this->venda, 3, '.', ' ');
        $this->vconexao = number_format($this->vconexao, 3, '.', ' ');

        // Popula o array de tarifas usando a enum
        $this->tarifas = TipoTarifa::options();

        //dd($this->tarifas);

        $this->carriers = Carrier::all()->map(function ($carrier) {
            return [
                'label' => $carrier->operadora,
                'value' => $carrier->id,
                'description' => $carrier->id,
            ];
        })->toArray();

        //dd($this->carriers);
    }

    public function store()
    {
        $this->compra = str_replace(',', '.', $this->compra);
        $this->compra = preg_replace('/\.(?=.*\.)/', '', $this->compra);

        $this->venda = str_replace(',', '.', $this->venda);
        $this->venda = preg_replace('/\.(?=.*\.)/', '', $this->venda);

        $this->vconexao = str_replace(',', '.', $this->vconexao);
        $this->vconexao = preg_replace('/\.(?=.*\.)/', '', $this->vconexao);

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
            'descricao' => ['required', 'string', 'min:3',
                function ($attribute, $value, $fail) {
                    $exists = Rate::where('tarifa', $this->tarifa_id)
                        ->where('carrier_id', $this->carrier_id)
                        ->where('prefixo', $this->prefixo)
                        ->first();

                    if ($exists) {
                        $fail('Esta combinação de tarifa, prefixo e operadora já existe!');
                    }
                },
            ],
        ]);

        try {
            Rate::create([
                'prefixo' => $this->prefixo,
                'carrier_id' => $this->carrier_id,
                'tarifa' => $this->tarifa_id,
                'descricao' => $this->descricao,
                'tempoinicial' => $this->tempoinicial,
                'tempominimo' => $this->tempominimo,
                'incremento' => $this->incremento,
                'compra' => $this->compra,
                'venda' => $this->venda,
                'vconexao' => $this->vconexao,
                'ativo' => $this->ativo,
            ]);

        } catch (\Exception $e) {
            dd($e);
            $this->slide = false;
            $this->toast()->error('Erro ao criar a Tarifa!')->send();

            return;
        }
        $this->cancel();
        $this->toast()->success('Tarifa criada com sucesso!')->send();

    }

    #[On('rate-create')]
    public function create()
    {
        $this->slide = true;
    }

    public function cancel()
    {
        $this->dispatch('table-update');
        $this->reset(['prefixo', 'carrier_id', 'tarifa_id', 'descricao', 'tempoinicial', 'tempominimo',
            'incremento', 'compra', 'venda', 'vconexao', 'ativo', ]);
        $this->slide = false;
    }

    public function render()
    {
        return view('livewire.rates.create');
    }
}
