<?php

namespace Modules\Customer\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }
}
