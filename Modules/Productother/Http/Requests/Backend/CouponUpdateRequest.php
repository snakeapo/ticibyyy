<?php

namespace Modules\Productother\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'coupon_name' => ['required'],
            'coupon_quantity' => ['required', 'integer', 'min:0'],
            'coupon_ratio' => ['required', 'numeric', 'min:0.01'],
            'discount_type' => ['required', 'in:fixed,percent'],
            'coupon_scope' => ['required', 'in:product,cart,both'],
            'coupon_code' => ['required', 'string', 'max:255', Rule::unique('coupons', 'coupon_code')->ignore($this->route('id'))],
            'description' => ['required'],
            'hide' => ['required'],
            'status' => ['required'],
        ];
    }
}
