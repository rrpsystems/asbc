<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Table extends Component
{
    public $headers = [];
    public function render()
    {
        return view('livewire.components.table');
    }
}
