<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'         => 'required|max:255|unique:products',
            'description'   => 'required',
            'price'         => 'required|integer',
            'image'         => 'required|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $product = $this->route()->parameter('product');

            $rules['title'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product),
            ];

            $rules['image'] = [
                'required|sometimes|mimes:jpg,jpeg,png,gif,svg|max:2048'
            ];
        }

        return $rules;
    }
}
