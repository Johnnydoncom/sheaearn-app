<?php

namespace App\Http\Livewire\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ShowProduct extends Component
{
    public $product;
    public $gallery = [];
    public $wishlist = [];
    public $affiliateUrl;
    public $related = [];
    public $cart;
    public $getTotalCartItem=null;

    protected $listeners = ['refreshProduct'=>'$refresh'];

    public function mount($slug)
    {
        $this->product = Product::with(['brand', 'categories'])->whereStatus(ProductStatus::PUBLISHED)->whereSlug($slug)->firstOrFail();
        $f = $this->product->getMedia('featured_image');

        $this->gallery[] = $f[0]->getUrl();
        $g = $this->product->getMedia('gallery');
        foreach($g as $key => $m){
            $this->gallery[$key+1] = $m->getUrl();
        }

        $this->wishlist = auth()->user() ? auth()->user()->wishlist()->where('product_id', $this->product->id)->first() : null;

        $this->affiliateUrl = auth()->user() ? route('product.show', ['slug'=>$slug, 'via' => auth()->user()->account_id]) : null;

        // Related products
        $this->related = Product::with('categories')->whereStatus(ProductStatus::PUBLISHED)->whereHas('categories', function ($q) {
            $q->whereIn('category_id', $this->product->categories->pluck('id'))->orWhereIn('category_id', $this->product->categories->pluck('parent_id'));
        })->where('id', '!=', $this->product->id)->inRandomOrder()->limit(4)->get();


//        $c = collect(\Cart::getContent())->filter(function($item){
//            return $item->associatedModel->id == $this->product->id;
//        });
//
//        if(count($c)>0){
//            $this->cart = $c;
//        }else{
//            $this->cart = null;
//        }
//
//        if(count($c)>0) {
//            $this->getTotalCartItem = $this->cart->sum('quantity');
//        }

    }

    public function render()
    {
        $c = collect(\Cart::getContent())->filter(function($item){
            return $item->associatedModel->id == $this->product->id;
        });

        if(count($c)>0){
            $this->cart = $c;
        }else{
            $this->cart = null;
        }

        if(count($c)>0) {
            $this->getTotalCartItem = $this->cart->sum('quantity');
        }

        return view('livewire.product.show-product');
    }

    public function add(){
        $this->emitTo('cart-action', 'addToCart', $this->product->id);
    }

    public function increase(){
        $this->emitTo('cart-action', 'updateCart', array_key_first($this->cart->toArray()), $this->getTotalCartItem+1);
    }

    public function decrease(){
        if($this->getTotalCartItem > 0)
        $this->emitTo('cart-action', 'updateCart', array_key_first($this->cart->toArray()), $this->getTotalCartItem-1);
    }

}
