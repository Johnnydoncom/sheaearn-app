<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_product_id' => $this->product_id,
            'sku' => $this->sku,
            'name' => $this->product->title,
            'stock' => $this->stock,
            'description' => $this->product->description,
            'sales_price' => $this->stock->sales_price,
            'regular_price' => $this->stock->regular_price,
            'stock_quantity' => $this->stock->stock_quantity,
            'attribute' => [
                'name' => $this->attribute->attribute->name,
                'value' => $this->option->value
            ],
            'attributes' => collect($this->variations)->map(function ($item) {
                return [
                    'name' => $item->attribute->attribute->name,
                    'option' => $item->option->value
                ];
            })->values()->toArray()
        ];
    }
}
