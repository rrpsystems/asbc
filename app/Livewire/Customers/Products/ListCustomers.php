<?php

namespace App\Livewire\Customers\Products;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListCustomers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 8;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::where('ativo', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nomefantasia', 'ilike', '%' . $this->search . '%')
                      ->orWhere('razaosocial', 'ilike', '%' . $this->search . '%');
                });
            })
            ->withCount('produtosAtivos')
            ->paginate($this->perPage);

        return view('livewire.customers.products.list-customers', [
            'customers' => $customers
        ]);
    }
}
