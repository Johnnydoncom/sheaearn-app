<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Events\CommissionEarned;
use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentGateway;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Zorb\Promocodes\Facades\Promocodes;
use Zorb\Promocodes\Models\Promocode;

class BundleCheckout extends Component
{
    public $product;
    public $currency, $vat, $payment_gateway, $coupon_code;

    protected $rules = [
        'coupon_code' => 'required|exists:promocodes,code',
    ];

    public function mount(SessionManager $session)
    {
        $this->product = Product::whereSpecial(true)->firstOrFail();
        $this->currency = setting('site_currency_name');
        $this->vat = 0;
        $this->subtotal = app_money_format($this->product->regular_price);
        $this->total = $this->product->regular_price + $this->vat;
        $this->payment_gateway = PaymentGateway::whereCode('coupon')->first();
    }


    public function render()
    {
        return view('livewire.bundle-checkout');
    }

    public function finalize($paystackRef=null)
    {
        // Check coupon validity
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if($c = Promocode::findByCode($this->coupon_code)->first()) {
                    if($c->usages_left < 1){
                        if(!$c->appliedByUser(auth()->user())){
                            $validator->errors()->add('coupon_code', 'Coupon already used!');
                        }
                    }
                }else{
                    $validator->errors()->add('coupon_code', 'Invalid coupon code');
                }
            });
        })->validate();

        // Apply Coupon
        $c = Promocode::findByCode($this->coupon_code)->first();

        if(!$c->appliedByUser(auth()->user())){
            Promocodes::code($this->coupon_code)
                ->user(User::find(auth()->user()->id)) // default: null
                ->apply();
        }

        $order = new Order();
        $order->grand_total = $this->total;
        $order->user_id = auth()->user()->id;
        $order->item_count = 1;
        $order->status = OrderStatus::COMPLETED;
        if($paystackRef) {
            $order->payment_status = PaymentStatus::APPROVED;
            $order->status = OrderStatus::PROCESSING;
        }
        if($this->coupon_code){
            $order->payment_status = PaymentStatus::APPROVED;
        }
        $order->save();

        // Order Items
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $this->product->id;
        $orderItem->quantity = 1;
        $orderItem->current_price = $this->product->regular_price;
        $orderItem->amount = $this->product->regular_price;
        $orderItem->status = OrderStatus::PROCESSING;
        $orderItem->save();

        auth()->user()->syncRoles([UserRole::AFFILIATE]);

        // Signup Commission
        if(setting('signup_bonus') > 0) {
            $tx =auth()->user()->deposit(setting('signup_bonus'), ['type' => 'signup_bonus', 'description' => 'Signup bonus for buying special bundle', 'product_id' => $this->product->id]);
            CommissionEarned::dispatch($tx);
        }

        // Referral Commission
        if(setting('referral_bonus') > 0) {
            if(Cookie::has('referral')){
                $ref = User::where('account_id', Cookie::get('referral'))->first();
                if($ref && $ref->hasRole(UserRole::AFFILIATE)) {
                    $tx2 = $ref->deposit(setting('referral_bonus'), ['type' => 'referral_bonus', 'description' => 'Commission for referring '. auth()->user()->name, 'product_id' => $this->product->id]);
                    CommissionEarned::dispatch($tx2);
                }
            }
        }

        $paymentHistory = new PaymentHistory();
        $paymentHistory->order_id = $order->id;
        $paymentHistory->user_id = auth()->user()->id;
        $paymentHistory->amount = $this->total;
        $paymentHistory->transaction_reference = $paystackRef ?? $this->coupon_code;

        $paymentHistory->transaction_type = 'account_upgrade';
        $paymentHistory->status = PaymentStatus::APPROVED;
        $paymentHistory->method = $this->payment_gateway->code;
        $paymentHistory->payment_gateway_id = $this->payment_gateway->id;
        $paymentHistory->save();

        OrderPlaced::dispatch($order);

        $url = URL::temporarySignedRoute('checkout.success', now()->addMinutes(1), ['order' => $order->id]);
        session()->flash('success', "Order Placed! Your account have been upgraded.");
        return redirect()->to($url);
    }
}
