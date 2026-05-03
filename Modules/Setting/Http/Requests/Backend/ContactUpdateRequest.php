<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mail_address' => ['sometimes'],
            'phone' => ['sometimes'],
            'whatsapp' => ['sometimes'],
            'address' => ['sometimes'],
        ];
    }
}
