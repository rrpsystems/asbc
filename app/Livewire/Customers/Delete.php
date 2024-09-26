<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{
    use Interactions;

    public $customer;

    #[On('customer-delete')]
    public function save($id): void
    {
        $this->customer = Customer::find($id);
        $this->toast()
            ->timeout(seconds: 10)
            ->question($this->customer->razaosocial, 'Deseja excluir este Cliente?')
            ->cancel('Confirmar', 'confirmed', 'Cliente excluido com sucesso!')
            //->cancel('Cancelar', 'cancelled', 'Cancelled Successfully')
            ->send();
    }

    public function confirmed(string $message): void
    {
        try {
            $this->customer->delete();
            $this->dispatch('table-update');
        } catch (\Exception $e) {
            //$this->toast()->error($e->getMessage());
            $this->toast()->error('Erro ao excluir o Cliente!')->send();

            return;
        }

        $this->toast()->success($message)->send();
    }

    public function cancelled(string $message): void {}

    public function render()
    {
        return view('livewire.customers.delete');
    }
}
