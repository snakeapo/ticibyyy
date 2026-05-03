<?php

namespace Modules\Customer\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required'],
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
            'user_phone' => ['sometimes'],
            'user_address' => ['sometimes'],
            'role' => ['required'],
            'sex' => ['required'],
            'password_confirm' => 'required',
            'password' => 'required|string|min:8',
        ];
    }
}
