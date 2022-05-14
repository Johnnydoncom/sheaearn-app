<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CartAction extends Component
{
    protected $listeners = ['addToCart', 'updateCart'];


    public function addToCart($id, $qty=1)
    {

        $product = Product::findOrFail($id);
        $suffix = '';

        $options = array(
            'product_id' => $product->id,
            'image' => $product->featured_img_thumb,
            'sales_price' =>$product->sales_price,
            'regular_price' => $product->regular_price,
            'formatted_sales_price' =>$product->formatted_sales_price,
            'formatted_regular_price' => $product->formatted_regular_price,
            'product_url' => route('product.show', $product->slug),
            'attributes' => array()
        );
        $price = $product->sales_price > 0 ? $product->sales_price : $product->regular_price;



        // Check stock quantity
        if($product->manage_stock && (!$product->stock_quantity || $qty > $product->stock_quantity)){
            throw ValidationException::withMessages([
                'quantity' => __('Out of stock'),
            ]);
        }


        \Cart::add([
            'id' => uniqid(),
            'product_id' => $id,
            'name' => $product->title . $suffix,
            'price' => (float)$price,
            'quantity' => $qty,
            'attributes' => $options,
            'associatedModel' => $product
        ]);

        // Check if in wishlist then delete
        if(auth()->user() && auth()->user()->wishlist()->where('product_id', $id)->exists()) {
            auth()->user()->wishlist()->where('product_id', $id)->delete();
        }

        $this->emit('refreshProduct');
        $this->emit('refreshCart');

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=> $product->title.' added to cart'
        ]);
    }


    public function updateCart($id, $qty){
//        \Cart::clear();
        if($id && $qty) {

            $cart = \Cart::get($id);
            $product = Product::find($cart->associatedModel->id);

            // Check stock quantity
            if($product->manage_stock && (!$product->stock_quantity || $qty > $product->stock_quantity)){
                throw ValidationException::withMessages([
                    'quantity' => __('Out of stock'),
                ]);
            }

            \Cart::update($id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $qty
                ),
            ));

            $this->emit('refreshProduct');
            $this->emit('refreshCart');

            // Set Flash Message
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=> 'Cart updated'
            ]);
        }

    }

    public function removeCart($id)
    {
        if($id) {
            \Cart::remove($id);

            $this->emit('refreshProduct');
            $this->emit('refreshCart');
            // Set Flash Message
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=> 'Product removed successfully'
            ]);
        }
    }
}
