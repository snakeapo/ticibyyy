<?php

namespace Modules\Customer\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_title' => ['required', 'max:255'],
            'phone' => ['required', 'digits_between:10,11'],
            'city' => ['required', 'max:255'],
            'town' => ['required', 'max:255'],
            'postal_code' => ['nullable', 'max:20'],
            'address' => ['required',  'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'address_title.required' => 'Adres başlığı alanı zorunludur.',
            'address_title.max' => 'Adres başlığı en fazla 255 karakter olabilir.',

            'phone.required' => 'Telefon alanı zorunludur.',
            'phone.digits_between' => 'Telefon numarası 10 veya 11 haneli olmalıdır.',

            'city.required' => 'İl alanı zorunludur.',
            'city.max' => 'İl alanı en fazla 255 karakter olabilir.',

            'town.required' => 'İlçe alanı zorunludur.',
            'town.max' => 'İlçe alanı en fazla 255 karakter olabilir.',

            'postal_code.max' => 'Posta kodu en fazla 20 karakter olabilir.',

            'address.required' => 'Adres alanı zorunludur.',
            'address.max' => 'Adres alanı en fazla 1000 karakter olabilir.',
        ];
    }
}
