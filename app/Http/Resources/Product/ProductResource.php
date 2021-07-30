<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'price'         => $this->price,
            'image'         => asset('storage/images/products/'.$this->image)
//            'image'         => Storage::get('app/public/images/products/'.$this->image)
        ];
    }
}
