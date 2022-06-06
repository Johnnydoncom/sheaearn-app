<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Zorb\Promocodes\Models\Promocode;
use Zorb\Promocodes\Facades\Promocodes;

class CouponCodes extends Component
{
    use WithPagination;
    public $count, $value, $coupon;

    public function mount(){
        $this->count = 5;
        $this->value = 2000;
    }

    public function render()
    {
        return view('livewire.admin.coupon-codes')->with([
            'coupons' => Promocode::paginate()
        ])->layout('layouts.admin');
    }

    public function store(){
        $codes = Promocodes::mask('NG-*****-SE') // default: config('promocodes.code_mask')
        ->multiUse(false) // default: false
        ->unlimited(false) // default: false
        ->count($this->count) // default: 1
//        ->expiration(now()->addYear()) // default: null
        ->details([ 'discount' => $this->value ]) // default: []
        ->create();

        $this->reset();


        if($c = Promocode::findByCode('NG-5Z3QP-SE')->first()) {
           if($c->usages_left>0){
               Promocodes::code('NG-5Z3QP-SE')
                   ->user(User::find(auth()->user()->id)) // default: null
                   ->apply();
           }else{
               $this->dispatchBrowserEvent('alert',[
                   'type'=>'error',
                   'message'=>"Coupon Used!"
               ]);
           }
        }else{
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Invalid Coupon!"
            ]);
        }

//        $this->emitSelf('coupon-generated');
        $this->dispatchBrowserEvent('coupon-generated');

        // Set Flash Message
//        $this->dispatchBrowserEvent('alert',[
//            'type'=>'success',
//            'message'=>"Coupon Generated!"
//        ]);
    }

    public function deleteCoupon($id){
        Promocode::find($id)->delete();

        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Coupon Deleted!"
        ]);
    }


}
