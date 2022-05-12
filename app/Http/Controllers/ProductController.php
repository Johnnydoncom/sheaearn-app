<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug){
        $product = Product::with(['brand', 'categories'])->whereStatus(ProductStatus::PUBLISHED)->whereSlug($slug)->firstOrFail();
        $f = $product->getMedia('featured_image');
        $gallery[] = $f[0]->getUrl();
        $g = $product->getMedia('gallery');
        foreach($g as $key => $m){
            $gallery[$key+1] = $m->getUrl();
        }

        $wishlist = $request->user() ? $request->user()->wishlist()->where('product_id', $product->id)->first() : null;

        $affiliateUrl = $request->user() ? route('product.show', ['slug'=>$product->slug, 'via' => $request->user()->account_id]) : null;

        // Related products
        $related = Product::with('categories')->whereStatus(ProductStatus::PUBLISHED)->whereHas('categories', function ($q) use($product){
            $q->whereIn('category_id', $product->categories->pluck('id'))->orWhereIn('category_id', $product->categories->pluck('parent_id'));
        })->where('id', '!=', $product->id)->inRandomOrder()->limit(4)->get();

//         SEOTools::setTitle($product->title);
//         SEOTools::setDescription(Str::limit($product->excerpt, 155));
//         SEOTools::opengraph()->addProperty('type', 'product');
// //        SEOTools::twitter()->setSite('@24');
//         SEOTools::jsonLd()->addImage($product->featured_img_url);
//         SEOTools::addImages($product->featured_img_url);
// //        OpenGraph::addImage(implode(',', $gallery));


        return view('product.show', [
            'product' => $product,
            'gallery' => $gallery,
            'reviews' => $product->reviews,
            'wishlist' => $wishlist,
            'affiliateUrl' => $affiliateUrl,
            'commission' => app_money_format($product->commission),
            'related' => $related
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
