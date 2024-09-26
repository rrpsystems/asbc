<?php

namespace App\Livewire\Rates;

use App\Models\Rate;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $rate;

    #[On('rate-delete')]
    public function save($id): void
    {
        $this->rate = Rate::find($id);
        $this->toast()
            ->timeout(seconds: 10)
            ->question($this->rate->prefixo.' - '.$this->rate->tarifa, 'Deseja excluir esta Tarifa?')
            ->cancel('Confirmar', 'confirmed', 'Tarifa excluida com sucesso!')
            //->cancel('Cancelar', 'cancelled', 'Cancelled Successfully')
            ->send();
    }

    public function confirmed(string $message): void
    {
        try {
            $this->rate->delete();
            $this->dispatch('table-update');
        } catch (\Exception $e) {
            //$this->toast()->error($e->getMessage());
            $this->toast()->error('Erro ao excluir a Tarifa!')->send();

            return;
        }

        $this->toast()->success($message)->send();
    }

    public function cancelled(string $message): void {}

    public function render()
    {
        return view('livewire.rates.delete');

    }
}
