<?php

namespace App\Http\Livewire\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Livewire\Component;

class ShowProduct extends Component
{
    public $product;
    public $gallery = [];
    public $wishlist = [];
    public $affiliateUrl;
    public $related = [];

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

    }

    public function render()
    {
        return view('livewire.product.show-product');
    }
}
