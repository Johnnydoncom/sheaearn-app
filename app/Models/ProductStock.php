<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'regular_price',
        'sales_price',
        'stock_quantity',
        'manage_stock',
        'sold_individually'
    ];

    protected $appends = [
        'formatted_regular_price',
        'formatted_sales_price',
        'discount_percent',
    ];

    public function getFormattedRegularPriceAttribute(){
        return app_money_format($this->regular_price);
    }

    public function getFormattedSalesPriceAttribute(){
        return app_money_format($this->sales_price);
    }

    public function getDiscountPercentAttribute(){
        return round((($this->regular_price - $this->sales_price) / $this->regular_price) * 100);
    }

    public function getVariationPriceAttribute(){
        $min = $this->variations()->stock->min('regular_price');
        $max = $this->variations()->max('regular_price');
        return $min==$max ? app_money_format($min) :  app_money_format($min). ' - ' . app_money_format($max);
    }


}
