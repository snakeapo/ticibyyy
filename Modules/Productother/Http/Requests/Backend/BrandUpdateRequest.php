<?php

namespace Modules\Productother\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_title' => ['required'],
            'brand_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif,webp'],
            'meta_keyw' => ['sometimes'],
            'meta_title' => ['sometimes'],
            'meta_desc' => ['sometimes'],
        ];
    }
}
