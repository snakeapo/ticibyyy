<?php

namespace Modules\Productother\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
