<?php

namespace Modules\Category\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_title' => ['required'],
            'meta_keyw' => ['sometimes'],
            'meta_title' => ['sometimes'],
            'meta_desc' => ['sometimes'],
            'home_show' => ['required'],
            'category_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
