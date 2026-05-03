<?php

namespace Modules\Page\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AnnonsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'annons_desc' => ['required'],
            'status' => ['required'],
        ];
    }
}
