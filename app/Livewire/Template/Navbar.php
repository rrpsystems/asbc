<?php

namespace App\Livewire\Template;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Navbar extends Component
{
    public $bradcrumb = [];

    #[On('bradcrumb')]
    public function changeBradcrumb($menu)
    {
        $this->bradcrumb = $menu;
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.template.navbar');
    }
}
