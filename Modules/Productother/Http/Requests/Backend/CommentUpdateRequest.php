<?php

namespace Modules\Productother\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answer' => ['required'],
        ];
    }
}
