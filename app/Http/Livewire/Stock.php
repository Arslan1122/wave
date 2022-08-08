<?php

namespace App\Http\Livewire;

use App\StockAttribute;
use Livewire\Component;
use Livewire\WithPagination;

class Stock extends Component
{
    use WithPagination;

    public function render()
    {
        $attributes = StockAttribute::all();
        $stocks = \App\Stock::with(['values', 'values.attribute'])->paginate(15);
        return view('livewire.stock', ['attributes' => $attributes, 'stocks' => $stocks]);
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }
}
