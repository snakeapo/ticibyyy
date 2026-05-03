<?php

namespace Modules\Page\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCommentCreateRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
