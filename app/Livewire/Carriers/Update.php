<?php

namespace App\Livewire\Carriers;

use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use App\Models\Carrier;
class Update extends Component
{
    use Interactions;
    public $contrato;
    public $old_contrato;
    public $operadora;
    public $data_inicio;
    public $canais;
    public $ativo;
    public $proxy;
    public $porta;
    public $valor_plano_mensal;
    public $dids_inclusos;
    public $franquia_valor_fixo;
    public $franquia_valor_movel;
    public $franquia_valor_nacional;
    public $franquia_compartilhada;
    public $carrier;
    public $modal = false;

 #[On('carrier-update')]
    public function edit($id)
    {
        $this->carrier = Carrier::find($id);
        $this->old_contrato = $this->carrier->id;
        $this->contrato = $this->carrier->id;
        $this->operadora = $this->carrier->operadora;
        $this->data_inicio = $this->carrier->data_inicio;
        $this->canais = $this->carrier->canais;
        $this->ativo = $this->carrier->ativo;
        $this->proxy = $this->carrier->proxy;
        $this->porta = $this->carrier->porta;
        $this->valor_plano_mensal = $this->carrier->valor_plano_mensal;
        $this->dids_inclusos = $this->carrier->dids_inclusos;
        $this->franquia_valor_fixo = $this->carrier->franquia_valor_fixo;
        $this->franquia_valor_movel = $this->carrier->franquia_valor_movel;
        $this->franquia_valor_nacional = $this->carrier->franquia_valor_nacional;
        $this->franquia_compartilhada = $this->carrier->franquia_compartilhada;
        $this->modal = true;
    }

    public function update()
    {
        $this->validate([
            'contrato' => 'required|numeric|unique:carriers,id,' . $this->old_contrato,
            'data_inicio' => 'required|date_format:Y-m-d',
            'canais' => 'required|numeric',
            'operadora' => 'required',
        ]);

        $data = [
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
        ];


        try {
            $this->carrier->update($data);
        } catch (\Exception $e) {
            $this->modal = false;
            $this->toast()->error('Erro ao alterar a Operadora!')->send();
            return;
        }

        $this->cancel();
        $this->toast()->success('Operadora alterada com sucesso!')->send();
    }

    public function cancel()
    {
	$this->modal = false;
        $this->dispatch('table-update');
        $this->resetValidation();
        $this->reset([
            'contrato',
            'old_contrato',
            'operadora',
            'data_inicio',
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
    }
    public function render()
    {
        return view('livewire.carriers.update');
    }
}
