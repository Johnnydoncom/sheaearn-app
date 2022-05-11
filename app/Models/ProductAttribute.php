<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    /**
     * Disable the timestamp on model creation
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields that can't be assign
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * @var array
     */
    protected $fillable = ['attribute_id', 'product_id'];

    /**
     * Add Value on the attribute
     *
     * @param string|array $value
     */
    public function addValue($value)
    {
        if (is_array($value)) {
            $terms = collect($value)->map(function ($term) {
                return ['value' => $term];
            })
//                ->values()
                ->toArray();

//            return $this->values()->createMany($terms);
            foreach ($value as $term){
                $this->values()->updateOrCreate(['value' => $term]);
            }
            return true;
        }
//        return $this->values()->create(['value' => $value]);
        return $this->values()->updateOrCreate(['value' => $value]);
    }



    /**
     * Remove a term on an attribute
     *
     * @param string $term
     */
    public function removeValue($term)
    {
        return $this->values()->where('value', $term)->firstOrFail()->delete();
    }

    /**
     * Relation of the attribute to the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo $this
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_attribute_id');
    }
}
