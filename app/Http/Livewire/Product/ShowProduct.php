<?php

namespace App\Http\Livewire\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
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


        $c = collect(\Cart::getContent())->filter(function($item){
            return $item->associatedModel->id == $this->product->id;
        });

        if(count($c)>0){
            $this->cart = $c;
        }else{
            $this->cart = null;
        }

    }

    public function render()
    {
        return view('livewire.product.show-product');
    }


    public function store(Request $request)
    {
//        \Cart::clear();

        $request->validate([
            'id'=>'required|exists:products'
        ]);
        $id = $request->id;
        $product = Product::with('stock')->findOrFail($id);
        $suffix = '';

        $options = array(
            'product_id' => $product->id,
            'variation_id' => null,
            'image' => $product->featured_img_thumb,
            'sales_price' =>$product->stock->sales_price,
            'regular_price' => $product->stock->regular_price,
            'formatted_sales_price' =>$product->stock->formatted_sales_price,
            'formatted_regular_price' => $product->stock->formatted_regular_price,
            'product_url' => route('product.show', $product->slug),
            'attributes' => array()
        );
        $price = $product->stock->sales_price > 0 ? $product->stock->sales_price : $product->stock->regular_price;



        // Check stock quantity

        if($product->stock->manage_stock && (!$product->stock->stock_quantity || $request->quantity > $product->stock->stock_quantity)){
            throw ValidationException::withMessages([
                'quantity' => __('Out of stock'),
            ]);
        }


        \Cart::add([
            'id' => uniqid(),
            'product_id' => $request->id,
            'name' => $product->title . $suffix,
            'price' => (float)$price,
            'quantity' => $request->quantity,
            'attributes' => $options,
            'associatedModel' => $product
        ]);

        // Check if in wishlist then delete
        if($request->user() && $request->user()->wishlist()->where('product_id', $request->id)->exists()) {
            $request->user()->wishlist()->where('product_id', $request->id)->delete();
        }


        return redirect()->back()->withSuccess($product->title.' added to cart');
    }

    public function update(Request $request){
//        \Cart::clear();
        if($request->id && $request->quantity) {

            $cart = \Cart::get($request->id);
            $product = Product::find($cart->associatedModel->id);

            // Check stock quantity
            if ($product->product_type == 'variable') {
                $var = ProductVariation::find($cart->attributes->variation_id);
                if($var->stock->manage_stock && $request->quantity > $var->stock->quantity){
                    throw ValidationException::withMessages([
                        'quantity' => __('Out of stock'),
                    ]);
                }
            } else {
                if($product->stock->manage_stock && (!$product->stock->stock_quantity || $request->quantity > $product->stock->stock_quantity)){
                    throw ValidationException::withMessages([
                        'quantity' => __('Out of stock'),
                    ]);
                }
            }

            \Cart::update($request->id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));
            return redirect()->back()->withSuccess('Cart updated');
        }

    }

}
