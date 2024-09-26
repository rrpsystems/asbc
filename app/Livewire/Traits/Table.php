<?php

namespace App\Livewire\Traits;


use Livewire\WithPagination;

trait Table
{
    use WithPagination;

    public string $search = '';
    public string $sort = 'id';
    public string $direction = 'asc';
    public int $perPage = 15;

    public function updatingperPage(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($by): void
    {
        if($by === $this->sort):
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
            $this->sort = $by;
        else:
            $this->direction = 'asc';
            $this->sort = $by;
        endif;

    }


}
