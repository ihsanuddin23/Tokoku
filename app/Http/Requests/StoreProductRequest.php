<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->sellerProfile !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'weight' => ['nullable', 'integer', 'min:0'],
            'condition' => ['required', 'in:new,used'],
            'status' => ['required', 'in:active,inactive,draft'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'variants' => ['nullable', 'array', 'max:10'],
            'variants.*.name' => ['required', 'string', 'max:100'],
            'variants.*.price_adjustment' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['required', 'integer', 'min:0'],
            'variants.*.sku' => ['nullable', 'string', 'max:100'],
        ];
    }
}
