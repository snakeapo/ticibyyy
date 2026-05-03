<?php

namespace Modules\Page\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SliderCreateRequest extends FormRequest
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
            'slider_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
}
