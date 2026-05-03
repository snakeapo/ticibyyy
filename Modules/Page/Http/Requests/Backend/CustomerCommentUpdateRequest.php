<?php

namespace Modules\Page\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_surname' => ['required'],
            'comment' => ['required'],
            'role' => ['required'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
