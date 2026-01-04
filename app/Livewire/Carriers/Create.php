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

    public $proxy;

    public $porta;

    public $valor_plano_mensal = 0;

    public $dids_inclusos = 0;

    public $franquia_valor_fixo = 0;

    public $franquia_valor_movel = 0;

    public $franquia_valor_nacional = 0;

    public $franquia_compartilhada = true;

    public $modal = false;

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
                'proxy' => $this->proxy,
                'porta' => $this->porta,
                'valor_plano_mensal' => $this->valor_plano_mensal ?? 0,
                'dids_inclusos' => $this->dids_inclusos ?? 0,
                'franquia_valor_fixo' => $this->franquia_valor_fixo ?? 0,
                'franquia_valor_movel' => $this->franquia_valor_movel ?? 0,
                'franquia_valor_nacional' => $this->franquia_valor_nacional ?? 0,
                'franquia_compartilhada' => $this->franquia_compartilhada ?? true,
            ]);

        } catch (\Exception $e) {
            //dd($e);
            $this->modal = false;
            $this->toast()->error('Erro ao criar a Operadora!')->send();

            return;
        }
        $this->cancel();
        $this->toast()->success('Operadora criada com sucesso!')->send();

    }

    #[On('carrier-create')]
    public function create()
    {
        $this->modal = true;
    }

    public function cancel()
    {
        $this->reset([
            'contrato',
            'operadora',
            'ativo',
            'canais',
            'proxy',
            'porta',
            'valor_plano_mensal',
            'dids_inclusos',
            'franquia_valor_fixo',
            'franquia_valor_movel',
            'franquia_valor_nacional',
            'franquia_compartilhada'
        ]);
        $this->data_inicio = now()->format('Y-m-d');
        $this->modal = false;
        $this->dispatch('table-update');
    }

    public function render()
    {
        return view('livewire.carriers.create');
    }
}
