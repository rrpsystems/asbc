<?php

namespace App\Livewire\Customers;

use App\Livewire\Traits\Table;
use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use Table;

    #[On('table-update')]
    public function render()
    {
        $customers = Customer::where('razaosocial', 'like', '%'.$this->search.'%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.customers.index', compact('customers'));
    }
}
