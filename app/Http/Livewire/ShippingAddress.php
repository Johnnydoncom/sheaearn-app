<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\State;
use Livewire\Component;

class ShippingAddress extends Component
{
    public $showAddForm = false;
    public $states;
    public $cities;

    public $editingAddress;


    public $first_name, $last_name, $phone, $address, $state, $city, $country;

    protected $rules = [
        'first_name' => ['required'],
        'last_name' => ['required'],
        'phone' => ['required'],
        'address' => ['required'],
        'state' => ['required'],
        'city' => ['required']
    ];

    public function mount(){
        $this->country = Country::where('iso2', 'NG')->first();
        $this->states = State::whereCountryCode('NG')->get();
        $this->cities = collect();
    }

    public function render()
    {
        return view('livewire.shipping-address', ['addresses' => auth()->user()->delivery_addresses]);
    }

    public function updatedState($state)
    {
        $this->cities = City::whereStateId($state)->get();
    }


    public function store(){
        $this->validate();

        auth()->user()->delivery_addresses()->create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'country_id' => $this->country->id,
            'state_id' => $this->state,
            'city_id' => $this->city
        ]);

        $this->reset(['first_name','last_name', 'phone', 'address', 'state', 'city', 'showAddForm', 'editingAddress']);

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Delivery Address Added!"
        ]);
    }

    public function selectAddress($id)
    {
        $address = DeliveryAddress::findOrFail($id);
        auth()->user()->delivery_addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('checkout.index');
    }

    public function edit($id){
        $this->editingAddress = DeliveryAddress::findOrFail($id);
        $this->first_name = $this->editingAddress->first_name;
        $this->last_name = $this->editingAddress->last_name;
        $this->phone = $this->editingAddress->phone;
        $this->address = $this->editingAddress->address;
        $this->state = $this->editingAddress->state_id;
        $this->city = $this->editingAddress->city_id;

        $this->cities = City::whereStateId($this->editingAddress->state_id)->get();
    }

    public function update(){
        $this->validate();

        $this->editingAddress->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'country_id' => $this->country->id,
            'state_id' => $this->state,
            'city_id' => $this->city
        ]);

        $this->reset(['first_name','last_name', 'phone', 'address', 'state', 'city', 'showAddForm', 'editingAddress']);

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Delivery Address Updated!"
        ]);
    }

    public function resetForm()
    {
        $this->reset(['first_name','last_name', 'phone', 'address', 'state', 'city', 'showAddForm', 'editingAddress']);
    }

}
