<?php

namespace Modules\Page\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'surname' => ['required'],
            'message' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
        ];
    }
}
