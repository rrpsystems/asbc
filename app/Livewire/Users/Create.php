<?php

namespace App\Livewire\Users;

use App\Enums\UserRole;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $name;

    public $rule = 'customer';

    public $email;

    public $password;

    public $password_confirmation;

    public $customer_id = null;

    public $ativo = true;

    public $slide = false;

    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'name' => 'required',
            'rule' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'rule' => $this->rule,
                'customer_id' => $this->customer_id,
                'ativo' => $this->ativo,
                'password' => bcrypt($this->password),
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: '.$e->getMessage()); // Registra o erro
            $this->slide = false;
            $this->toast()->error('Erro ao criar o usuário!')->send();

            return;
        }
        $this->cancel();
        $this->toast()->success('Usuário criado com sucesso!')->send();

    }

    #[On('user-create')]
    public function create()
    {
        $this->slide = true;
    }

    public function cancel()
    {
        $this->resetValidation();
        $this->dispatch('table-update');
        $this->reset(['name', 'rule', 'ativo', 'email', 'password', 'password_confirmation', 'customer_id']);
        $this->slide = false;
    }

    public function getRoles()
    {
        return collect(UserRole::cases())->map(function($role) {
            return [
                'value' => $role->value,
                'label' => $role->label(),
            ];
        })->toArray();
    }

    public function getCustomers()
    {
        $customers = Customer::where('ativo', true)
            ->orderBy('nomefantasia')
            ->get()
            ->map(function($customer) {
                return [
                    'value' => $customer->id,
                    'label' => $customer->nomefantasia ?? $customer->razaosocial ?? 'Cliente #' . $customer->id,
                ];
            })
            ->filter(function($customer) {
                return !empty($customer['label']);
            })
            ->values()
            ->toArray();

        return $customers;
    }

    public function render()
    {
        return view('livewire.users.create', [
            'roles' => $this->getRoles(),
            'customers' => $this->getCustomers(),
        ]);
    }
}
