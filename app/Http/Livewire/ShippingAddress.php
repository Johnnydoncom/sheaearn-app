<?php

namespace App\Http\Livewire;

use App\Models\State;
use Livewire\Component;

class ShippingAddress extends Component
{
    public $showAddForm;
    public $statesData;

    public function mount(){
        $this->statesData = State::whereCountryCode('NG')->get();
    }

    public function render()
    {
        return view('livewire.shipping-address', ['addresses' => auth()->user()->delivery_addresses]);
    }
}
