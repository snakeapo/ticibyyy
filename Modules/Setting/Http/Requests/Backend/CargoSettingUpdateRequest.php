<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CargoSettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cargo_title' => ['required'],
            'cargo_price' => ['required'],
            'cargo_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'cargo_time' => ['required'],
        ];
    }
}
