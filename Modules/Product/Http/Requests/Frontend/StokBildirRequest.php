<?php

namespace Modules\Product\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StokBildirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required'],
        ];
    }
}
