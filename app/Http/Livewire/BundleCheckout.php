<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
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
use Illuminate\Support\Str;
use Livewire\Component;

class BundleCheckout extends Component
{
    public $product;
    public $currency, $vat, $payment_gateway;

    public function mount(SessionManager $session)
    {
        $this->product = Product::whereSpecial(true)->firstOrFail();
        $this->currency = setting('site_currency_name');
        $this->vat = 0;
        $this->subtotal = app_money_format($this->product->regular_price);
        $this->total = $this->product->regular_price + $this->vat;
        $this->payment_gateway = PaymentGateway::whereCode('paystack')->first();
    }

    public function render()
    {
        return view('livewire.bundle-checkout');
    }

    public function finalize($paystackRef=null)
    {

        $order = new Order();
        $order->grand_total = $this->total;
        $order->user_id = auth()->user()->id;
        $order->item_count = 1;
        $order->status = OrderStatus::PROCESSING;
        if($paystackRef) {
            $order->payment_status = PaymentStatus::APPROVED;
            $order->status = OrderStatus::PROCESSING;
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

        // Signup Commission
        if(setting('signup_bonus') >0) {
            auth()->user()->deposit(setting('signup_bonus'), ['type' => 'signup_bonus', 'description' => 'Signup bonus for buying product', 'product_id' => $this->product->id]);
        }

        auth()->user()->assignRole(UserRole::AFFILIATE);

        $paymentHistory = new PaymentHistory();
        $paymentHistory->order_id = $order->id;
        $paymentHistory->user_id = auth()->user()->id;
        $paymentHistory->amount = $this->total;
        $paymentHistory->transaction_reference = $paystackRef;

        $paymentHistory->transaction_type = 'orders';
        $paymentHistory->status = PaymentStatus::APPROVED;
        $paymentHistory->method = $this->payment_gateway->id;
        $paymentHistory->payment_gateway_id = $this->payment_gateway->id;
        $paymentHistory->save();

        OrderPlaced::dispatch($order);

        $url = URL::temporarySignedRoute('checkout.success', now()->addMinutes(1), ['order' => $order->id]);
        session()->flash('success', "Order Placed! Your account have been upgraded.");
        return redirect()->to($url);
    }
}
