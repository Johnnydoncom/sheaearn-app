<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'status', 'grand_total', 'item_count', 'payment_status',
        'shipping_charges', 'delivery_address_id', 'address', 'city', 'country', 'post_code', 'phone_number', 'notes'
    ];

    protected $appends = [
        'total',
        'date',
        'status_label'
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(new OrderObserver());
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery_address(){
        return $this->belongsTo(DeliveryAddress::class);
    }

    public function getDateAttribute(){
        return $this->created_at->format('d-m-Y');
    }

    public function getTotalAttribute(){
        return app_money_format($this->grand_total);
    }

    public function payment(){
        return $this->hasOne(PaymentHistory::class);
    }

    public function getStatusLabelAttribute(){
        return config('appstore.orderstatus')[$this->status];
    }
}
