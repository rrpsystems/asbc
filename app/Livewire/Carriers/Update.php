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
    public $carrier;
    public $slide = false;

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
        $this->slide=true;
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
        ];


        try {
            $this->carrier->update($data);
        } catch (\Exception $e) {
            $this->slide=false;
            $this->toast()->error('Erro ao alterar a Operadora!')->send();
            return;
        }

        $this->cancel();
        $this->toast()->success('Operadora alterada com sucesso!')->send();
    }

    public function cancel()
    {
	$this->slide=false;
        $this->dispatch('table-update');
        $this->resetValidation();
        $this->reset(['contrato', 'old_contrato', 'operadora','data_inicio', 'ativo', 'canais']);
    }
    public function render()
    {
        return view('livewire.carriers.update');
    }
}
