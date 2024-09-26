<?php

namespace App\Livewire\Carriers;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\Table;
use App\Models\Carrier;

class Index extends Component
{
    use Table;
    #[On('table-update')]
    public function render()
    {
        $carriers = Carrier::where('operadora', 'like', '%' . $this->search . '%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->perPage);

        return view('livewire.carriers.index', compact('carriers'));
    }
}
