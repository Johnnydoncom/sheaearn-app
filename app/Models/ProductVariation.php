<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    /**
     * Disable timestamp
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields that can be mass assigned
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_sku_id',
        'product_attribute_id',
        'product_stock_id',
        'product_attribute_value_id',
        'code',
        'price',
        'cost',
        'quantity',
        'sku'
    ];

    protected $with = ['stock'];

    /**
     * Protected fields during mass assigned
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function option()
    {
        return $this->belongsTo(ProductAttributeValue::class, 'product_attribute_value_id');
    }

    public function stock()
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id');
    }
}
