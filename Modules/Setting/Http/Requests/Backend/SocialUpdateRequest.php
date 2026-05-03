<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SocialUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'facebook' => ['sometimes'],
            'twitter' => ['sometimes'],
            'youtube' => ['sometimes'],
            'instagram' => ['sometimes'],
            'linkedin' => ['sometimes'],
            'pinterest' => ['sometimes'],
        ];
    }
}
