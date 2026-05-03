<?php

namespace Modules\Category\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sub_title' => ['required'],
            'parent_target' => ['required', 'string'],
            'meta_keyw' => ['sometimes'],
            'meta_title' => ['sometimes'],
            'meta_desc' => ['sometimes'],
        ];
    }
}
