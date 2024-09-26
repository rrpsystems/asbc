<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions;

    public $id;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $user;

    public $slide = false;

    public $ativo;

    public $rule = 'customer';

    #[On('user-update')]
    public function edit($id)
    {
        $this->user = User::find($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->rule = $this->user->rule;
        $this->ativo = $this->user->ativo;
        $this->slide = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'rule' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'rule' => $this->rule,
            'ativo' => $this->ativo,
        ];

        if (! empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        try {
            $this->user->update($data);
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: '.$e->getMessage()); // Registra o erro
            $this->slide = false;
            $this->toast()->error('Erro ao criar o usuário!')->send();

            return;
        }

        $this->cancel();
        $this->toast()->success('Usuário alterado com sucesso!')->send();
    }

    public function cancel()
    {
        $this->resetValidation();
        $this->dispatch('table-update');
        $this->reset(['name', 'rule', 'ativo', 'email', 'password', 'password_confirmation']);
        $this->slide = false;
    }

    public function render()
    {
        return view('livewire.users.update');
    }
}
