<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ShowCart extends Component
{
    protected $listeners = ['refreshCart' => '$refresh'];


    public function render()
    {
        return view('livewire.show-cart', [
            'cart' => \Cart::getContent()->map(function ($cart){
                $cart['variation'] = null;
                $cart['available_quantity'] = 0;

                $product = Product::find($cart->associatedModel->id);

                if($product->manage_stock) {
                    $cart['available_quantity'] = $product->stock_quantity;
                    $cart['manage_stock'] = $product->manage_stock;
                }
                return $cart;
            }),
            'totalQuantity' => \Cart::getTotalQuantity(),
            'subtotal'=> app_money_format((float)\Cart::getSubTotal()),
            'total' => app_money_format((float)\Cart::getTotal())
        ]);
    }


    public function updateQuantity($cartId, $qty){
        $this->emitTo('cart-action', 'updateCart', $cartId, $qty);
    }

    public function removeCart($cartId){
        $this->emitTo('cart-action', 'removeCart', $cartId);
    }

    public function increase($cartId,$qty){
        $this->emitTo('cart-action', 'updateCart', $cartId, $qty);
    }

    public function decrease($cartId,$qty){
        if($qty > 1)
            $this->emitTo('cart-action', 'updateCart', $cartId, $qty);
    }
}
