<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVariation;
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
        return view('admin.product.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
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











    public function store(Request $request){
        $request->validate([
            'title' => 'required|min:6',
            'category_ids' => 'required',
            'regular_price' => 'required_unless:product_type,variable',
            'product_type' => 'required',
            'stock_status' => 'required_unless:product_type,variable',
            'digital_file' => 'required_if:product_type,digital',
            'variations' => 'required_if:product_type,variable',
            'featured_image' => 'image|max:1024', // 1MB Max
        ]);

        if($request->product_type != 'variable'){
            $productStock = ProductStock::create([
                'manage_stock' => $request->manage_stock ? true : false,
                'regular_price' => (float)$request->regular_price ?? null,
                'sales_price' => (float)$request->sales_price ?? 0,
                'stock_quantity' => $request->stock_quantity ?? null,
                'sold_individually' => $request->sold_individually ? true : false
            ]);
        }

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->user_id  = Auth::id();
        $product->regular_price = (float)$request->regular_price ?? null;
        $product->sales_price = (float)$request->sales_price ?? 0;
        $product->type = $request->product_type;
        $product->product_type = $request->product_type;
        $product->product_attributes = $request->product_attributes;
        $product->featured = $request->featured ? true : false;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->manage_stock = $request->manage_stock ? true : false;
        $product->stock_quantity = $request->stock_quantity ?? null;
        $product->sold_individually = $request->sold_individually ? true : false;
        $product->stock_status = $request->stock_status;
        $product->commission = $request->commission;
        if($request->user()->hasRole(UserRole::VENDOR)) {
            $product->status = ProductStatus::DRAFT;
        }
        if($request->product_type != 'variable'){
            $product->product_stock_id = $productStock->id;
        }

        $product->save();

        if($request->attributes){
            $addAttributes = [];
            foreach ((array)$request->get('attributes') as $attr){
                if($attr['id'] != null) {
                    $addAttributes[] = array('attribute_id' => $attr['id']);

                    // Add Product Attribute
                    $product->addAttribute($attr['id']);

                    // Add terms
                    if($attr['value']) {
                        $product->addAttributeTerm($attr['id'], $attr['value']);
                    }
                }else{
                    $attribute = Attribute::create(['name'=>$attr['name']]);
                    $addAttributes[] = array('attribute_id' => $attribute->id);

                    // Add Product Attribute
                    $product->addAttribute($attribute->id);

                    // Add custom terms
                    $terms= explode('|', $attr['value']);
                    if($terms)
                        $product->addAttributeTerm($attribute->id, $terms);
                }
            }
        }

        // Variations
        if($request->variations && $request->product_type == 'variable'){
            foreach ((array)$request->get('variations') as $variation) {
                $productStock = ProductStock::create([
                    'manage_stock' => $request->manage_stock ? true : false,
                    'regular_price' => $variation['regular_price'],
                    'sales_price' => $variation['sales_price'],
                    'stock_quantity' => $variation['stock_quantity'],
                    'sold_individually' => $request->sold_individually ? true : false
                ]);

                $variant = [
                    'sku' => $variation['sku'],
                    'price' => $variation['sales_price'],
                    'cost' => $variation['regular_price'],
                    'quantity' => $variation['stock_quantity'] ?? null,
                    'product_stock_id' => $productStock->id,
                    'variation' => [
                        ['option' => 'size', 'value' => $variation['attribute_value']]
                    ]
                ];
                $product->addVariant($variant);
            }
        }


        // Categories
        $product->categories()->sync($request->category_ids);


        // Featured Image
        if($request->featured_image) {
            $product->addMedia($request->featured_image)->toMediaCollection('featured_image');
        }

        // digital file
        if($request->digital_file) {
            $product->addMedia($request->digital_file)->toMediaCollection('digital');
        }

        // Gallery
        if($request->gallery && count($request->gallery)) {
            $product->clearMediaCollection('gallery');
            foreach ($request->gallery as $key => $image) {
                $product->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.products.index')->withSuccess('Product Created');
    }

    public function edit($id){
        $product = Product::with(['categories','brand', 'attributes', 'variations'])->findOrFail($id);

        // Attributes
        $attributes = $product->loadAttributes()->map(function ($item){
            $item->value_array = $item->values->pluck('value');
            return $item;
        });

        // Variations
        $variations = $product->loadVariations()->map(function ($item){
            return [
                'id' => $item->id,
                'sku' => $item->sku,
                'regular_price'=> $item->stock->regular_price,
                'sales_price'=> $item->stock->sales_price,
                'stock_quantity'=> $item->stock->stock_quantity,
                'attribute_name'=> $item->attribute->attribute->name,
                'attribute_code'=> $item->attribute->attribute->code,
                'attribute_value'=> $item->option->value,
            ];
        });

        return Inertia::render('Admin/Products/Edit',
            [
                'categories' => Category::with(['childrenRecursive'])->whereNull('parent_id')->get(),
                'brands' => Brand::get(['name','id']),
                'attributes' => Attribute::all(),
                'productTypes' => config('appstore.product_types'),
                'product' => $product,
                'product_category_ids' => $product->categories->pluck('id'),
                'product_attributes' => $attributes,
                'product_variations' => $variations
            ]);
    }

    public function update(Request $request, Product $product){
        $request->validate([
            'title' => 'required|min:6',
            'category_ids' => 'required',
            'regular_price' => 'required_unless:product_type,variable',
            'product_type' => 'required',
            'stock_status' => 'required_unless:product_type,variable',
        ]);

        if($request->product_type != 'variable'){
            $productStock = $product->stock->update([
                'manage_stock' => $request->manage_stock ? true : false,
                'regular_price' => (float)$request->regular_price ?? null,
                'sales_price' => (float)$request->sales_price ?? 0,
                'stock_quantity' => $request->stock_quantity ?? null,
                'sold_individually' => $request->sold_individually ? true : false
            ]);
        }


        $product->title = $request->title;
        $product->description = $request->description;
        $product->regular_price = (float)$request->regular_price ?? null;
        $product->sales_price = (float)$request->sales_price ?? 0;
        $product->type = $request->product_type;
        $product->product_type = $request->product_type;
        $product->product_attributes = $request->product_attributes;
        $product->featured = $request->featured ? true : false;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->manage_stock = $request->manage_stock ? true : false;
        $product->stock_quantity = $request->stock_quantity ?? null;
        $product->sold_individually = $request->sold_individually ? true : false;
        $product->stock_status = $request->stock_status;
        $product->commission = $request->commission;
        if($request->product_type != 'variable'){
            $product->product_stock_id = $productStock->id;
        }
        $product->save();

        // Attributes
        if($request->attributes){
            $addAttributes = [];
            foreach ((array)$request->get('attributes') as $attr){
                if($attr['id'] != null) {
                    $addAttributes[] = array('attribute_id' => $attr['id']);

                    if($product->attributes()->where('attribute_id', $attr['id'])->exists()){
                        // update terms
                        $product->updateAttributeTerm($attr['id'], $attr['value']);

                    }else {
                        // Add Product Attribute
                        $product->addAttribute($attr['id']);

                        // Add terms
                        $product->addAttributeTerm($attr['id'], $attr['value']);
                    }
                }else{
                    $attribute = Attribute::create(['name'=>$attr['name']]);
                    $addAttributes[] = array('attribute_id' => $attribute->id);

                    // Add Product Attribute
                    $product->addAttribute($attribute->id);

                    // Add custom terms
                    $terms= explode('|', $attr['value']);
                    if($terms)
                        $product->addAttributeTerm($attribute->id, $terms);
                }
            }
        }

        // Variations
        if($request->variations){
            foreach ((array)$request->get('variations') as $variation) {
                if(isset($variation['id'])) {
                    ProductVariation::find($variation['id'])->stock->update([
                        'manage_stock' => $request->manage_stock ? true : false,
                        'regular_price' => $variation['regular_price'],
                        'sales_price' => $variation['sales_price'],
                        'stock_quantity' => $variation['stock_quantity'],
                        'sold_individually' => $request->sold_individually ? true : false
                    ]);
                }else{
                    if($variation['regular_price']) {
                        $productStock = ProductStock::create([
                            'manage_stock' => $request->manage_stock ? true : false,
                            'regular_price' => $variation['regular_price'],
                            'sales_price' => $variation['sales_price'],
                            'stock_quantity' => $variation['stock_quantity'],
                            'sold_individually' => $request->sold_individually ? true : false
                        ]);
                    }
                }

                if($variation['regular_price']) {
                    $variant = [
                        'sku' => $variation['sku'],
                        'price' => $variation['sales_price'],
                        'cost' => $variation['regular_price'],
                        'quantity' => $variation['stock_quantity'] ?? null,
//                    'product_stock_id' => $productStock->id,
                        'variation' => [
                            ['option' => 'size', 'value' => $variation['attribute_value']]
                        ]
                    ];

                    if (isset($productStock))
                        $variant['product_stock_id'] = $productStock->id;

                    $product->addVariant($variant);
                }
            }
        }

        // Categories
        $product->categories()->sync($request->category_ids);

        // Featured Image
        if($request->featured_image) {
            $product->addMedia($request->featured_image)->toMediaCollection('featured_image');
        }

        // digital file
        if($request->digital_file) {
            $product->addMedia($request->digital_file)->toMediaCollection('digital');
        }

        // Gallery
        if($request->gallery && count($request->gallery)) {
//            $product->clearMediaCollection('gallery');
            foreach ($request->gallery as $key => $image) {
                $product->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.products.index')->withSuccess('Product Updated');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('admin.products.index')->withSuccess('Product Deleted');
    }
}
