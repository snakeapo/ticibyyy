<?php

namespace Modules\Customer\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPostRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'user_phone' => ['required'],
            'avatar' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'user_phone.required' => 'Telefon numarası zorunludur.',

            'avatar.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'avatar.mimes' => 'Avatar yalnızca jpg, jpeg, png, webp veya svg formatında olmalıdır.',
            'avatar.max' => 'Avatar dosyası en fazla 2MB olabilir.',
        ];
    }
}
