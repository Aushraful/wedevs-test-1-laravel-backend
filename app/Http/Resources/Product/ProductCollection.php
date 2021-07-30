<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'image' => asset('storage/images/products/'.$this->image),
            'href'  => [
                'link' => route('products.show', $this->id)
            ]
        ];
    }
}
