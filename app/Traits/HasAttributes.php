<?php

namespace App\Traits;


use App\Exceptions\InvalidAttributeException;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

trait HasAttributes
{
    /**
     * Create a product attribute
     *
     * @param array $attributeData
     * @throw  \Ronmrcdo\Inventory\Exceptions\InvalidAttributeException
     * @return $this
     */
    public function addAttribute($attribute)
    {
        DB::beginTransaction();

        try {
            if(!$this->attributes()->where('attribute_id',$attribute)->exists())
            $this->attributes()->create(['attribute_id' => $attribute]);

            DB::commit();
        } catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
            DB::rollBack();

            throw new InvalidAttributeException($err->getMessage(), 422);
        }

        return $this;
    }

    /**
     * Create multiple attributes
     *
     * @param mixed $attributes
     * @throw  \Ronmrcdo\Inventory\Exceptions\InvalidAttributeException
     * @return $this
     */
    public function addAttributes($attributes)
    {
        DB::beginTransaction();

        try {
            $this->attributes()->createMany($attributes);

            DB::commit();
        } catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
            DB::rollBack();

            throw new InvalidAttributeException($err->getMessage(), 422);
        }

        return $this;
    }

    /**
     * It should remove attribute from product
     *
     * @param string $key
     * @return self
     */
    public function removeAttribute($attr)
    {
        DB::beginTransaction();

        try {
            $attribute = $this->attributes()->where('attribute_id', $attr)->firstOrFail();

            $attribute->delete();

            DB::commit();
        } catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
            DB::rollBack();

            throw new InvalidAttributeException($err->getMessage(), 422);
        }

        return $this;
    }

    /**
     * It should remove attribute from product
     *
     * @param string $key
     * @return self
     */
    public function removeAttributeTerm($attribute, string $term)
    {
        DB::beginTransaction();

        try {
            $attribute = $this->attributes()->where('attribute_id', $attribute)->firstOrFail();

            $attribute->removeValue($term);

            DB::commit();
        } catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
            DB::rollBack();

            throw new InvalidAttributeException($err->getMessage(), 422);
        }

        return $this;
    }


    public function hasAttributes()
    {
        return !! $this->attributes()->count();
    }


    public function hasAttribute($key)
    {
        // If the arg is a numeric use the id else use the name
        if (is_numeric($key)) {
            return $this->attributes()->where('id', $key)->exists();
        } elseif (is_string($key)) {
            return $this->attributes()->where('attribute_id', $key)->exists();
        }

        return false;
    }

    /**
     * Add Option Value on the attribute
     *
     * @param string $option
     * @param mixed $value
     *
     * @throw \Ronmrcdo\Inventory\Exceptions\InvalidAttributeException
     *
     * @return \App\Models\ProductAttributeValue
     */
    public function addAttributeTerm($option, $value)
    {
        $attribute = $this->attributes()->where('attribute_id', $option)->first();

        if (! $attribute) {
            throw new InvalidAttributeException("Invalid attribute", 422);
        }

        return $attribute->addValue($value);
    }

    public function updateAttributeTerm($option, $value)
    {
        $attribute = $this->attributes()->where('attribute_id', $option)->first();

        if (! $attribute) {
            throw new InvalidAttributeException("Invalid attribute", 422);
        }

        return $attribute->addValue($value);
    }

    public function loadAttributes()
    {
        return $this->attributes()->with('attribute')->get()->load('values');
    }


    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

//    public function pro_attributes()
//    {
//        return $this->hasMany(ProductAttribute::class, 'product_id', 'attribute_id');
//    }

    public function pro_attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id', 'attribute_id');
    }
}
