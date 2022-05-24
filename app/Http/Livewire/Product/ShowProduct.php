<?php

namespace App\Http\Livewire\Product;

use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Events\CommissionEarned;
use App\Models\Entry;
use App\Models\Product;
use App\Models\Share;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
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
        $this->related = Product::with('categories')->whereSpecial(false)->whereStatus(ProductStatus::PUBLISHED)->whereHas('categories', function ($q) {
            $q->whereIn('category_id', $this->product->categories->pluck('id'))->orWhereIn('category_id', $this->product->categories->pluck('parent_id'));
        })->where('id', '!=', $this->product->id)->inRandomOrder()->limit(4)->get();

    }

    public function render()
    {
//        \Cart::clear();
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

        SEOTools::setTitle($this->product->title);
        SEOTools::setDescription($this->product->excerpt);
        // SEOTools::opengraph()->setUrl('http://current.url.com');
        // SEOTools::setCanonical('https://codecasts.com.br/lesson');
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::twitter()->setSite('@Sheaearn');
        SEOTools::jsonLd()->addImage($this->product->featured_img_url);
        SEOTools::opengraph()->addProperty('article:published_time', $this->product->created_at->toW3cString(), 'property');
        SEOMeta::addMeta('fb:app_id', env('FB_APP_ID'), 'property');
        OpenGraph::addImage($this->product->featured_img_url);

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


    public function addToCart($qty=1)
    {

        $options = array(
            'product_id' => $this->product->id,
            'image' => $this->product->featured_img_thumb,
            'sales_price' =>$this->product->sales_price,
            'regular_price' => $this->product->regular_price,
            'formatted_sales_price' =>$this->product->formatted_sales_price,
            'formatted_regular_price' => $this->product->formatted_regular_price,
            'product_url' => route('product.show', $this->product->slug),
            'attributes' => array()
        );
        $price = $this->product->sales_price > 0 ? $this->product->sales_price : $this->product->regular_price;



        // Check stock quantity
        if($this->product->manage_stock && (!$this->product->stock_quantity || $qty > $this->product->stock_quantity)){
            throw ValidationException::withMessages([
                'quantity' => __('Out of stock'),
            ]);
        }


        \Cart::add([
            'id' => uniqid(),
            'product_id' => $this->product->id,
            'name' => $this->product->title,
            'price' => $price,
            'quantity' => $qty,
            'attributes' => $options,
            'associatedModel' => Product::find($this->product->id)
        ]);

        // Check if in wishlist then delete
        if(auth()->user() && auth()->user()->wishlist()->where('product_id', $this->product->id)->exists()) {
            auth()->user()->wishlist()->where('product_id', $this->product->id)->delete();
        }

        $this->emit('refreshCart',
        [
           'cart'=> \Cart::getContent(),
           'itemCount' => \Cart::getContent()->count()
        ]);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=> $this->product->title.' added to cart'
        ]);
    }


    public function updateCart($id, $qty){
//        \Cart::clear();
        if($id && $qty) {

            $cart = \Cart::get($id);
            // $product = Product::find($cart->associatedModel->id);

            // Check stock quantity
            if($this->product->manage_stock && (!$this->product->stock_quantity || $qty > $this->product->stock_quantity)){
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

            // $this->emit('refreshProduct');
            $this->emit('refreshCart',
            [
               'cart'=> \Cart::getContent(),
               'itemCount' => \Cart::getContent()->count()
            ]);

            // Set Flash Message
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=> 'Cart updated'
            ]);
        }

    }


    public function shared($method)
    {
        if(Share::whereShareableType(Product::class)->whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::today())->count() < 10) {
            if ($record = $this->product->shares()->whereUserId(auth()->user()->id)->first()) {
                if ($record->created_at->isToday()) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => "Product already shared"
                    ]);
                } else {
                    $this->processShare($method);

                    // Set Flash Message
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'success',
                        'message' => "Product shared."
                    ]);
                }

            } else {
                $this->processShare($method);

                // Set Flash Message
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',
                    'message' => "Product shared."
                ]);
            }
        }
    }

    private function processShare($method)
    {
        if(auth()->user()->hasRole(UserRole::AFFILIATE)) {
            $this->product->shares()->create([
                'user_id' => auth()->user()->id,
                'social_id' => $method
            ]);

            if (setting('share_commission')) {
                $tx = auth()->user()->socialWallet()->deposit(setting('share_commission'), ['type' => 'share_commission', 'description' => 'Commission for sharing product', 'product_id' => $this->product->id]);

                CommissionEarned::dispatch($tx);
            }
        }
    }
}
