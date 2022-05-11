<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'is_default',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'phone',
        'additional_phone',
        'postcode'
    ];

    protected $with = [
        'country',
        'state',
        'city'
    ];

    protected $appends = [
        'name'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function getNameAttribute(){
        return $this->last_name.' '.$this->first_name;
    }

    public function getFullAddressAttribute(){
        return $this->address.', '.$this->city->name.', '.$this->country->name;
    }

}
