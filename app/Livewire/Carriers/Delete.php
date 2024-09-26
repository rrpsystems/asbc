<?php

namespace App\Livewire\Carriers;

use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use App\Models\Carrier;
class Delete extends Component
{
    use Interactions;
    public $carrier;

#[On('carrier-delete')]
    public function save($id): void
{
    $this->carrier = Carrier::find($id);
    $this->toast()
        ->timeout(seconds: 10)
        ->question($this->carrier->operadora,'Deseja excluir esta Operadora?')
        ->cancel('Confirmar', 'confirmed', 'Operadora excluida com sucesso!')
        //->cancel('Cancelar', 'cancelled', 'Cancelled Successfully')
        ->send();
}

public function confirmed(string $message): void
{
    try {
        $this->carrier->delete();
        $this->dispatch('table-update');
    } catch (\Exception $e) {
        //$this->toast()->error($e->getMessage());
        $this->toast()->error('Erro ao excluir a Operadora!')->send();
        return;
    }

    $this->toast()->success($message)->send();
}

public function cancelled(string $message): void
{
    return;
}

    public function render()
    {
        return view('livewire.carriers.delete');
    }
}
