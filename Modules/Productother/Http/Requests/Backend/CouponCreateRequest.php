<?php

namespace Modules\Productother\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CouponCreateRequest extends FormRequest
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
            'coupon_code' => ['required', 'string', 'max:255', 'unique:coupons,coupon_code'],
            'description' => ['required'],
            'hide' => ['required'],
            'status' => ['required'],
        ];
    }
}
