<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class LanguageSettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'language_name' => ['required'],
            'language_code' => ['required'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
