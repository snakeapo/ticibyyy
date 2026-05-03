<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AuthInfoCardCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
