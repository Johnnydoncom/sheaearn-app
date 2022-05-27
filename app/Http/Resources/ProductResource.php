<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->title,
            'slug' => $this->slug,
            'sku' => $this->hasVariation() ? $this->variations()->first()->sku : $this->sku,
            'short_description' => Str::limit(strip_tags($this->description), 150, '...'),
            'description' => $this->description,
            'sales_price' => $this->hasVariation() ? app_money_format($this->variations()->first()->price) : app_money_format($this->sales_price),
            'regular_price' => $this->hasVariation() ? app_money_format($this->variations()->first()->cost) : app_money_format($this->regular_price),
            'is_active' => $this->status,
            'attributes' => AttributeResource::collection($this->attributes->load('values'))->toArray(app('request')),
            'variations' => $this->when($this->hasAttributes() && $this->hasVariation(),
                VariationResource::collection($this->variations)->groupBy('attribute.attribute.name')->toArray(app('request'))
            ),
            'categories' => $this->when($this->categories,
                CategoryResource::collection($this->categories)->toArray(app('request'))
            ),
            'featured_image_thumb' => $this->featured_img_thumb,
            'featured_img_url' => $this->featured_img_url,
            'gallery' => $this->getMedia('gallery'),
            'product_type' => $this->product_type,
            'type' => $this->type,
            'featured' => $this->featured,
            'stock_status' => $this->stock_status,
            'brand_id' => $this->brand_id,
            'brand' => $this->brand,
            'sold_individually' => $this->sold_individually,
            'views_count' => $this->views_count,
            'formatted_regular_price' => $this->formatted_regular_price,
            'formatted_sales_price' => $this->formatted_sales_price,
            'discount_percent' => $this->discount_percent,

        ];
    }
}
