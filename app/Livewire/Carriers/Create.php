<?php

namespace App\Livewire\Carriers;

use App\Models\Carrier;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $contrato;

    public $operadora;

    public $data_inicio;

    public $canais = 30;

    public $ativo = true;

    public $slide = false;

    public function mount()
    {
        $this->data_inicio = now()->format('Y-m-d');
    }

    public function store()
    {
        $this->validate([
            'contrato' => 'required|numeric|unique:carriers,id',
            'data_inicio' => 'required|date_format:Y-m-d',
            'canais' => 'required|numeric',
            'operadora' => 'required',
        ]);

        try {
            Carrier::create([
                'id' => $this->contrato,
                'operadora' => $this->operadora,
                'data_inicio' => $this->data_inicio,
                'canais' => $this->canais,
                'ativo' => $this->ativo,
            ]);

        } catch (\Exception $e) {
            //dd($e);
            // $this->dispatch('carrier-close');
            $this->slide = false;
            $this->toast()->error('Erro ao criar a Operadora!')->send();

            return;
        }
        $this->cancel();
        $this->toast()->success('Operadora criada com sucesso!')->send();

    }

    #[On('carrier-create')]
    public function create()
    {
        $this->slide = true;
    }

    public function cancel()
    {
        $this->reset(['contrato', 'operadora', 'ativo', 'canais']);
        $this->data_inicio = now()->format('Y-m-d');
        $this->slide = false;
        $this->dispatch('table-update');
    }

    public function render()
    {
        return view('livewire.carriers.create');
    }
}
