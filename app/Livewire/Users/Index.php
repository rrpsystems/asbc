<?php

namespace App\Livewire\Users;

use App\Livewire\Traits\Table;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    #[On('table-update')]
    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.users.index', compact('users'));
    }
}
