<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_name',
        'coupon_quantity',
        'coupon_ratio',
        'discount_type',
        'coupon_scope',
        'coupon_code',
        'description',
        'hide',
        'status',
    ];

    public function getDiscountAmount(float $amount): float
    {
        if ($amount <= 0) {
            return 0;
        }

        $ratio = (float) $this->coupon_ratio;
        $discountType = $this->discount_type ?? 'fixed';

        if ($discountType === 'percent') {
            $discount = ($amount * $ratio) / 100;
        } else {
            $discount = $ratio;
        }

        return min($discount, $amount);
    }

    public function getTypeLabelAttribute(): string
    {
        return ($this->discount_type ?? 'fixed') === 'percent' ? 'Yüzde (%)' : 'Sabit Tutar (TL)';
    }
}
