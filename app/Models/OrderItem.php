<?php

namespace App\Models;

use App\Observers\OrderItemObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'amount', 'order_number', 'current_price', 'product_variation_id'
    ];

    protected $with = [
      'product'
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(new OrderItemObserver());
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
