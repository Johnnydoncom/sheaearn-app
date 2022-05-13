<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShippingAddress extends Component
{
    public $showAddForm;

    public function render()
    {
        return view('livewire.shipping-address', ['addresses' => auth()->user()->delivery_addresses]);
    }
}
