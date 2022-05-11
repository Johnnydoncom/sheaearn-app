<?php

namespace App\Http\Livewire\Admin;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Product;
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
    public $attributes;
    public $brands = [];
    public $allTags;
    public $allAttributes;
    public $images = [];
    public $image;
    public $digital_file;
    public $category_ids = [];

    public $product_id, $title, $description, $price, $stock_quantity, $featured, $category_id, $brand_id, $regular_price, $sales_price=0, $product_type, $stock_status, $commission, $status, $sku, $manage_stock;

    protected $rules = [
        'title' => 'required|min:6',
        'description' => 'required|min:5',
        'category_ids' => 'required',
        'regular_price' => 'required_unless:product_type,variable',
        'product_type' => 'required',
        'stock_status' => 'required',
        'image' => 'image|max:1024|nullable'
    ];

    public function mount(){
        $this->categories = Category::whereNull('parent_id')->get();
        $this->allTags = Tag::get();
        $this->allAttributes = Attribute::all();
        $this->brands = Brand::get(['name','id']);


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
            $this->product_type = $this->product->type;
            $this->brand_id = $this->product->brand_id;
            $this->status = $this->product->status ? 1 : 0;
        }else{
            $this->manage_stock = 0;
            $this->product_type = 'physical';
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

        $product = $this->product ?? new Product();
        $product->title = $this->title;
        $product->regular_price = $this->regular_price;
        $product->sales_price = $this->sales_price ?? 0;
        $product->category_id = $this->category_id;

        if(!$this->product)
            $product->user_id = auth()->user()->id;

        $product->type = $this->product_type;
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
}
