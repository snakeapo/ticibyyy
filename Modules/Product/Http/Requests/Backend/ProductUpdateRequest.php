<?php

namespace Modules\Product\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['sometimes'],
            'feature' => ['sometimes'],
            'installment' => ['sometimes'],
            'category' => ['required', 'exists:categories,id'],
            'sub_category' => ['required', 'exists:subcategories,id'],
            'brand' => ['required'],
            'price' => ['required'],
            'sale_price' => ['sometimes'],
            'stock' => ['required'],
            'our_choice' => ['sometimes'],
            'best_selling' => ['sometimes'],
            'has_return' => ['required', 'boolean'],
            'has_exchange' => ['required', 'boolean'],
            'whatsapp_order_enabled' => ['required', 'boolean'],
            'meta_title' => ['sometimes'],
            'meta_keyw' => ['sometimes'],
            'meta_desc' => ['sometimes'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ];
    }
}
