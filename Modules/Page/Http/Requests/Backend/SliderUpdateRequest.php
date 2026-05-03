<?php

namespace Modules\Page\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slider_title' => ['required'],
            'slider_desc' => ['required'],
            'slider_button' => ['required'],
            'slider_link' => ['required'],
            'status' => ['required'],
            'slider_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
