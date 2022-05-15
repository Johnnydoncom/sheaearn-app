<?php

namespace App\Http\Livewire;

use App\Models\PaymentGateway;
use Illuminate\Session\SessionManager;
use Livewire\Component;

class FinalizeCheckout extends Component
{
    public $payment_method;
    public $delivery_address;

    public $subtotal, $payTotal, $total, $totalQuantity, $cart, $shippingCost, $currency, $user_email, $paystack_key;


    public function mount(SessionManager $session)
    {
        $this->delivery_address = auth()->user()->delivery_address;
        $this->payment_method = PaymentGateway::find($session->get('payment_method'));

        $this->subtotal = app_money_format((float)\Cart::getSubTotal());
        $this->payTotal = \Cart::getTotal() + $session->get('shipping_cost');
        $this->total = app_money_format((float)\Cart::getTotal() + $session->get('shipping_cost'));
        $this->totalQuantity = \Cart::getTotalQuantity();
        $this->cart = \Cart::getContent();
        $this->shippingCost = app_money_format($session->get('shipping_cost'));
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

    public function payWithPaystack()
    {

    }

    public function payOnDelivery()
    {

    }
}
