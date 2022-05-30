<?php

namespace App\Http\Livewire;

use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Events\CommissionEarned;
use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentGateway;
use App\Models\PaymentHistory;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;

class FinalizeCheckout extends Component
{
    public $payment_method;
    public $delivery_address;

    public $subtotal, $payTotal, $total, $totalQuantity, $cart, $shippingCost=0, $currency, $user_email, $paystack_key, $notes;

    public $payingWithPaystack = false;


    public function mount(SessionManager $session)
    {
        $this->delivery_address = auth()->user()->delivery_address;
        $this->payment_method = PaymentGateway::find($session->get('payment_method'));

        $this->subtotal = app_money_format((float)\Cart::getSubTotal());
        $this->payTotal = \Cart::getTotal() + $session->get('shipping_cost');
        $this->total = app_money_format((float)\Cart::getTotal() + $session->get('shipping_cost'));
        $this->totalQuantity = \Cart::getTotalQuantity();
        $this->cart = \Cart::getContent();
        $this->shippingCost = $session->get('shipping_cost');
        $this->currency = setting('site_currency_name');
        $this->user_email = auth()->user()->email;
        $this->paystack_key = setting('paystack_key');
    }

    public function render()
    {
        if(!auth()->user()->delivery_address){
            return redirect()->route('checkout.index');
        }

        return view('livewire.finalize-checkout');
    }


    public function finalize($paystackRef=null)
    {
            $total = \Cart::getTotal();
            $cartCollection = \Cart::getContent();

            $grandTotal = $total + $this->shippingCost;

            $order = new Order();
            $order->grand_total = $grandTotal;
            $order->user_id = auth()->user()->id;
            $order->delivery_address_id = $this->delivery_address->id;
            $order->notes = $this->notes;
            $order->item_count = $cartCollection->count();
            $order->shipping_charges = $this->shippingCost;
            $order->status = 'order_placed';
            if($paystackRef) {
                $order->payment_status = PaymentStatus::APPROVED;
                $order->status = 'processing';
            }
            $order->save();

            // Order Items
            $productIds = array();
            foreach ($cartCollection as $cart) {

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cart->associatedModel->id;
                $orderItem->quantity = $cart->quantity;
                $orderItem->current_price = $cart->price;
                $orderItem->amount = $cart->getPriceSum();
                 $orderItem->product_variation_id = $cart->attributes->variation_id;
                $orderItem->status = 'processing';
                $orderItem->save();

                $productIds[$cart->associatedModel->id] = $cart->associatedModel->id;

                // Update stock quantity
                if($cart->associatedModel->manage_stock) {
                    if ($cart->associatedModel->product_type == 'variable') {
                        $updateStock = ProductVariation::find($cart->attributes->variation_id)->stock->decrement('stock_quantity', (int)$cart->quantity);
                    }
                    else {
                        if(!is_null($cart->associatedModel->stock->stock_quantity))
                            $cart->associatedModel->stock->decrement('quantity', $cart->quantity);
                    }
                }

                // Affiliate Commission
                if(Cookie::get('affiliate')){
                    $ref = User::where('account_id', Cookie::get('affiliate'))->first();
                    if($ref && $ref->hasRole(UserRole::AFFILIATE)) {
                        if ($cart->associatedModel->commission > 0) {
                            $tx = $ref->deposit($cart->associatedModel->commission, ['type' => 'order_commission', 'description' => 'Commission for buying product', 'product_id' => $cart->associatedModel->id]);
                            CommissionEarned::dispatch($tx);
                        }
                    }

                    Cookie::forget('affiliate');
                    Cookie::forget('referral');
                }
            }

            //Store Payment Record
            // $paymentMethod = PaymentGateway::find($request->session()->get('payment_method'));
            $paymentHistory = new PaymentHistory();
            $paymentHistory->order_id = $order->id;
            $paymentHistory->user_id = auth()->user()->id;
            $paymentHistory->amount = $grandTotal;
            if($paystackRef) {
                $paymentHistory->transaction_reference = $paystackRef;
            }else{
                $paymentHistory->transaction_reference = generateUniqueReferenceNumber();
            }
            $paymentHistory->transaction_type = 'orders';
            if(Str::contains($this->payment_method->name, ['paystack', 'Paystack']) || Str::contains($this->payment_method->title, ['paystack', 'Paystack'])){
                $paymentHistory->status = PaymentStatus::APPROVED;
            }
            $paymentHistory->method = $this->payment_method->id;
            $paymentHistory->payment_gateway_id = $this->payment_method->id;
            $paymentHistory->save();
             OrderPlaced::dispatch($order);

            // clear cart session
            \Cart::clear();
            session()->forget(['shipping_cost', 'payment_method']);

            $url = URL::temporarySignedRoute('checkout.success', now()->addMinutes(1), ['order' => $order->id]);
            session()->flash('success', 'Order Placed');
            return redirect()->to($url);
    }
}
