<?php

namespace Modules\Order\Http\Requests\Frontend;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $paymentSystems = ['1', '3'];

        if ((bool) optional(Settings::find(1))->cash_on_delivery_enabled) {
            $paymentSystems[] = '2';
        }

        return [
            'user_address' => ['nullable', 'integer', 'exists:address,id'],
            'address_title' => ['required_without:user_address', 'nullable', 'string', 'max:255'],
            'city' => ['required_without:user_address', 'nullable', 'string', 'max:255'],
            'town' => ['required_without:user_address', 'nullable', 'string', 'max:255'],
            'address' => ['required_without:user_address', 'nullable', 'string', 'max:1000'],
            'postal_code' => ['required_without:user_address', 'nullable', 'string', 'max:50'],
            'phone' => ['required_without:user_address', 'nullable', 'string', 'max:30'],
            'cargo' => ['required', 'integer', 'exists:cargos,id'],
            'payment_system' => ['required', Rule::in($paymentSystems)],
            'order_note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
