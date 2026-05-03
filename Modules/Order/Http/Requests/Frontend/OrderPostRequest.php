<?php

namespace Modules\Order\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class OrderPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_title' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'town' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'postal_code' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:30'],
            'cargo' => ['required', 'integer', 'exists:cargos,id'],
            'payment_system' => ['required', 'in:1,2,3'],
            'order_note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
