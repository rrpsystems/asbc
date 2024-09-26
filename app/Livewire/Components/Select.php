<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Select extends Component
{
    public $field = 'Select';
    public $selectedValue = '';
    public $options = [];
    public $hasValue = false; // Adicione uma propriedade para gerenciar o estado da label

    public function mount()
    {
        // Inicialize hasValue com base no selectedValue
        $this->hasValue = !empty($this->selectedValue);
    }

    public function render()
    {

        return view('livewire.components.select');
    }
}
