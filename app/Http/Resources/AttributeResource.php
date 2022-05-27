<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return $this->collection;
        return [
            'id' => $this->id,
            'name' => $this->attribute->name,
            'options' => collect($this->values)->map(function ($item) {
                return $item->value;
            })->values()->toArray()
        ];
    }
}
