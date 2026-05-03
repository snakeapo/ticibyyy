<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ImageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,ico,svg,webp|max:1024',
            'light_logo' => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ];
    }
}
