<?php

namespace App\Http\Livewire\Admin;

use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVariation;
use App\Models\Tag;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $product;
    public $tags = [];
    public $sticky = false;
    public $categories;
    public $pattributes=[];
    public $brands = [];
    public $allTags;
    public $allAttributes;
    public $images = [];
    public $image;
    public $digital_file;
    public $category_ids = [];
    public $selAttribute;
    public $variations = [];

    public $product_id, $title, $description, $price, $stock_quantity, $featured, $category_id, $brand_id, $regular_price, $sales_price=0, $product_type, $type, $stock_status, $commission, $status, $sku, $manage_stock, $sold_individually;

    protected $rules = [
        'title' => 'required|min:6',
        'description' => 'required|min:5',
        'category_ids' => 'required',
        'regular_price' => 'required_unless:product_type,variable',
        'stock_status' => 'required_unless:product_type,variable',
        'product_type' => 'required',
        'digital_file' => 'required_if:type,digital',
        'variations' => 'required_if:product_type,variable',
        'type' => 'required',
        'image' => 'image|max:1024|nullable'
    ];

    public function mount(){
        $this->categories = Category::whereNull('parent_id')->get();
        $this->allTags = Tag::get();
        $this->allAttributes = Attribute::all();
        $this->brands = Brand::get(['name','id']);

        $this->selAttribute = 'custom';


        if($this->product){
            $this->title = $this->product->title;
            $this->description = $this->product->description;
            $this->manage_stock = $this->product->manage_stock;
            $this->stock_status = $this->product->stock_status;
            $this->stock_quantity = $this->product->stock_quantity;
            $this->featured = $this->product->featured;
            $this->category_ids = $this->product->categories->pluck('id');

            $this->regular_price = $this->product->regular_price;
            $this->sales_price = $this->product->sales_price;
            $this->commission = $this->product->commission;
            $this->sku = $this->product->sku;
            $this->product_type = $this->product->product_type;
            $this->type = $this->product->type;
            $this->brand_id = $this->product->brand_id;
            $this->status = $this->product->status ? 1 : 0;

            // Attributes
            $pattributes = $this->product->loadAttributes()->map(function ($item){
                $item->value_array = $item->values->pluck('value')->toArray();
                return $item;
            });

            foreach ($pattributes as $att){
                $this->pattributes[] = array(
                    'name' => $att->attribute->name,
                    'value' => $att->value_array,
                    'type' => null,
                    'code' => $att->attribute->code,
                    'id' => $att->attribute->id
                );
            }

//            print_r($this->pattributes);
//            exit();

            // Variations
            $this->variations = $this->product->loadVariations()->map(function ($item){
                return [
                    'id' => $item->id,
                    'sku' => $item->sku,
                    'regular_price'=> $item->stock->regular_price,
                    'sales_price'=> $item->stock->sales_price,
                    'stock_quantity'=> $item->stock->stock_quantity,
                    'attribute'=> $item->attribute->attribute->name,
                    'attribute_code'=> $item->attribute->attribute->code,
                    'attribute_value'=> $item->option->value,
                ];
            });

        }else{
            $this->manage_stock = 0;
            $this->product_type = 'simple';
            $this->type = 'physical';
            $this->stock_status = 'instock';
            $this->status = 0;
            $this->featured = false;
        }
    }


    public function render()
    {
        return view('livewire.admin.product-form');
    }

    public function store(){
        $this->validate();

        if(!$this->product && $this->product_type != 'variable'){
            $productStock = ProductStock::create([
                'manage_stock' => $this->manage_stock ? true : false,
                'regular_price' => (float)$this->regular_price ?? null,
                'sales_price' => (float)$this->sales_price ?? 0,
                'stock_quantity' => $this->stock_quantity ?? null,
                'sold_individually' => $this->sold_individually ? true : false
            ]);
        }

        $product = $this->product ?? new Product();
        $product->title = $this->title;
        $product->regular_price = $this->regular_price;
        $product->sales_price = $this->sales_price ?? 0;
        $product->category_id = $this->category_id;

        if(!$this->product) {
            $product->user_id = auth()->user()->id;

            if($this->product_type != 'variable'){
                $product->product_stock_id = $productStock->id;
            }
        }

        if(auth()->user()->hasRole(UserRole::VENDOR)) {
            $product->status = ProductStatus::DRAFT;
        }

        $product->type = $this->type;
        $product->product_type = $this->product_type;
        $product->product_attributes = $this->pattributes;

        $product->description = $this->description;

        $product->featured = $this->featured ? true : false;
        $product->brand_id = $this->brand_id;
        $product->sku = $this->sku;
        $product->stock_quantity = $this->stock_quantity ?? null;
        $product->stock_status = $this->stock_status;
        $product->commission = $this->commission ?? 0;
        $product->manage_stock = $this->manage_stock;
        $product->save();

        // Categories
        $product->categories()->sync($this->category_ids);

        // digital file
        if($this->digital_file) {
            $product->addMedia($this->digital_file->getRealPath())->toMediaCollection('digital');
        }

        // Tags
        if($this->tags) {
            foreach ($this->tags as $key => $tag) {
                if (!is_numeric($tag)) {
                    $new = Tag::create(['name' => $tag, 'user_id' => auth()->user()->id]);
                    $this->tags[$key] = $new->id;
                }
            }
            $product->tags()->sync($this->tags);
        }


        // Product Attrivutes
        if($this->pattributes){
            $addAttributes = [];
            foreach ($this->pattributes as $attr){
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
        if($this->variations && $this->product_type == 'variable'){
            foreach ($this->variations as $variation) {
                if(isset($variation['id'])) {
                    ProductVariation::find($variation['id'])->stock->update([
                        'manage_stock' => $this->manage_stock ? true : false,
                        'regular_price' => $variation['regular_price'],
                        'sales_price' => $variation['sales_price'],
                        'stock_quantity' => $variation['stock_quantity'],
                        'sold_individually' => $this->sold_individually ? true : false
                    ]);
                }else{
                    if($variation['regular_price']) {
                        $productStock = ProductStock::create([
                            'manage_stock' => $this->manage_stock ? true : false,
                            'regular_price' => $variation['regular_price'],
                            'sales_price' => $variation['sales_price'],
                            'stock_quantity' => $variation['stock_quantity'],
                            'sold_individually' => $this->sold_individually ? true : false
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
            }
        }

        if($this->image)
            $product
                ->addMedia($this->image->getRealPath())
                ->toMediaCollection('featured_image');

        // Add gallery
        if($this->images) {
            foreach ($this->images as $image) {
                $product
                    ->addMedia($image->getRealPath())
                    ->toMediaCollection('gallery');
            }
        }

        if(!$this->product)
            $this->reset(['title','description','image', 'images', 'category_ids', 'tags', 'regular_price', 'sales_price', 'stock_quantity', 'manage_stock', 'type', 'featured', 'brand_id', 'sku', 'commission', 'stock_status']);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Product Created Successfully!!"
        ]);

        return redirect()->route('admin.products.index');
    }

    public function removeGallery($key){
        unset($this->images[$key]);
    }

    public function removeGalleryById($id){
        Media::find($id)->delete();
        $this->product = Product::find($this->product->id);
//        unset($this->images[$id]);
    }


    public function addAttribute(){
        if($this->selAttribute == 'custom'){
            $this->pattributes[] = array(
                'name'=> null,
                'value'=> null,
                'type'=> 'custom',
                'code'=>null,
                'id'=>null
            );
        }else {
            $att = $this->allAttributes->where('code', $this->selAttribute)->first();
            if(!collect($this->pattributes)->where('code', $att->code)->first()) {
                $this->pattributes[] = array(
                    'name' => $att->name,
                    'value' => null,
                    'type' => null,
                    'code' => $att->code,
                    'id' => $att->id
                );
            }
        }

        $this->emitSelf('attributeSelected');
        $this->dispatchBrowserEvent('attribute-selected');

    }

    public function removeAttribute($index){
        unset($this->pattributes[$index]);
    }

    public function addVariation(){
        $attr = collect($this->pattributes)->where('code', 'size')->first();
        if($attr){
            foreach ($attr['value'] as $k => $v){
                $this->variations[] = array(
                    'sku' => null,
                    'regular_price' => null,
                    'sales_price'=> null,
                    'stock_quantity'=> null,
                    'attribute'=> $attr['name'],
                    'attribute_code' => $attr['code'],
                    'attribute_value' => $v
                );
            }
        }
    }


}
