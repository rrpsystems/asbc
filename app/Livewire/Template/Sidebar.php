<?php

namespace App\Livewire\Template;
use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;

class Sidebar extends Component
{
    public $dropdown = '';
    public $currentRouteName;

    // Função para exibir os dropdown do sidebar
    public function toogleDropdown($dropdown)
    {
        if ($this->dropdown == $dropdown) {
            $this->dropdown = '';
        } else {
            $this->dropdown = $dropdown;
        }
    }

    public function mount()
    {
        $this->currentRouteName = Route::currentRouteName();
    }

    public function render()
    {
        return view('livewire.template.sidebar');
    }
}
