<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use App\Models\User;
class Delete extends Component
{
    use Interactions;
    public $user;

#[On('user-delete')]
    public function save($id): void
{
    $this->user = User::find($id);
    $this->toast()
        ->timeout(seconds: 10)
        ->question($this->user->name,'Deseja excluir este usuário?')
        ->cancel('Confirmar', 'confirmed', 'Usuário excluido com sucesso!')
        //->cancel('Cancelar', 'cancelled', 'Cancelled Successfully')
        ->send();
}

public function confirmed(string $message): void
{
    try {
        $this->user->delete();
        $this->dispatch('user-close');
    } catch (\Exception $e) {
        //$this->toast()->error($e->getMessage());
        $this->toast()->error('Erro ao excluir o usuário!')->send();
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
        return view('livewire.users.delete');
    }
}
