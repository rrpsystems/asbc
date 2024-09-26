<?php

namespace App\Livewire\Template;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Navbar extends Component
{

    public $sideToggle = true;
    public $bradcrumb = [];

    #[On('bradcrumb')]
    public function changeBradcrumb($menu)
    {
        $this->bradcrumb = $menu;
    }
    #[On('close-sidebar')]
    public function toggleSidebar()
    {
        $this->sideToggle = !$this->sideToggle;
        // Emitir evento para o componente Sidebar
        $this->dispatch('toggleSidebar', $this->sideToggle);
        $this->dispatch('toggle-sidebar', $this->sideToggle);
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
