<?php

namespace Modules\Blog\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryInsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_title' => ['required'],
            'meta_keyw' => ['required'],
            'meta_title' => ['required'],
            'meta_desc' => ['required'],
        ];
    }
}
