<?php

namespace Modules\Productother\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AskQuestionPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ask' => ['required'],
        ];
    }
}
