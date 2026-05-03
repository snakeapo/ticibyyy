<?php

namespace Modules\Page\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_title' => ['required'],
            'page_desc' => ['required'],
            'meta_title' => ['required'],
            'meta_keyw' => ['required'],
            'meta_desc' => ['required'],
        ];
    }
}
