<?php

namespace Modules\Customer\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password_confirm' => 'required',
            'password' => 'required|string|min:8',
        ];
    }
}
