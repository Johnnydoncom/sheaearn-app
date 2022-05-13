<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowCheckout extends Component
{
    public function render()
    {
        return view('livewire.show-checkout', [
            'cart' => \Cart::getContent(),
            'totalQuantity' => \Cart::getTotalQuantity(),
            'subtotal'=> app_money_format((float)\Cart::getSubTotal()),
            'total' => app_money_format((float)\Cart::getTotal()),
            'delivery_address' => auth()->user() ? auth()->user()->delivery_address : null
        ]);
    }
}
