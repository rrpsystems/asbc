<?php

namespace App\Livewire\Rates;

use App\Livewire\Traits\Table;
use App\Models\Rate;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    #[On('table-update')]
    public function render()
    {

        $rates = Rate::with('carrier')->where('descricao', 'like', '%'.$this->search.'%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.rates.index', compact('rates'));
    }
}
