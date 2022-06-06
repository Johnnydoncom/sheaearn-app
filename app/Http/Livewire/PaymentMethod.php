<?php

namespace App\Http\Livewire;

use App\Models\PaymentGateway;
use Illuminate\Session\SessionManager;
use Livewire\Component;

class PaymentMethod extends Component
{
    public $shippingCost;
    public $default_payment_method;
    public $payment_method;

    protected $rules = [
        'payment_method' => ['required']
    ];

    public function mount(SessionManager $session)
    {
        $address = auth()->user()->delivery_address;
        if($address->state_id == setting('origin_state_id')){
            $this->shippingCost = setting('intra_state_shipping_fee') ?? 0;
        }else{
            $this->shippingCost = setting('inter_state_shipping_fee') ?? 0;
        }
        $session->put('shipping_cost', $this->shippingCost);

        if($session->get('payment_method')){
            $this->payment_method = $session->get('payment_method');
        }
    }

    public function render()
    {
        if(!auth()->user()->delivery_address){
            return redirect()->route('checkout.index');
        }

        $payment_methods = PaymentGateway::whereCode('bank')->get();

        $this->default_payment_method = PaymentGateway::where('name', 'like', '%paystack%')->first() ?? $payment_methods[0];

        return view('livewire.payment-method',[
            'cart' => \Cart::getContent(),
            'totalQuantity' => \Cart::getTotalQuantity(),
            'subtotal'=> app_money_format((float)\Cart::getSubTotal()),
            'total' => app_money_format((float)\Cart::getTotal() + $this->shippingCost),
            'shippingCost' => app_money_format($this->shippingCost),
            'payment_methods' => PaymentGateway::whereCode('bank')->get()
        ]);
    }


    public function store()
    {
        $this->validate();
        session()->put('payment_method', $this->payment_method);
        return redirect()->route('checkout.finish');
    }

}
