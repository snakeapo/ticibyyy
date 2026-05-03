<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class GeneralUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meta_title' => ['required'],
            'meta_keyw' => ['required'],
            'meta_desc' => ['required'],
            'footer' => ['required'],
            'footer_desc' => 'required|string|max:191',
        ];
    }
}
