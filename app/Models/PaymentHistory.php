<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'user_id',
        'amount',
        'method',
        'reference',
        'transaction_reference',
        'payment_gateway_id'
    ];

    public function payment_gateway(){
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
