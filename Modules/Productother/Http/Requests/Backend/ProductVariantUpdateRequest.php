<?php

namespace Modules\Productother\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'variant_name' => ['required'],
            'variant_type' => ['required'],
            'parent_variant_type' => ['nullable'],
            'parent_variant_name' => ['nullable'],
            'variant_price' => ['required'],
            'variant_stock' => ['required'],
            'variant_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
