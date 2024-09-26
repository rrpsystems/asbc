<?php

namespace App\Livewire\Dids;

use App\Livewire\Traits\Table;
use App\Models\Did;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    #[On('table-update')]
    public function render()
    {

        $dids = Did::with('carrier')->with('customer')->where('did', 'like', '%'.$this->search.'%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.dids.index', compact('dids'));
    }
}
