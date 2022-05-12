<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;

class ProductLayoutOne extends Component
{
    public $product;

    public function render()
    {
        return view('livewire.product.product-layout-one');
    }
}
