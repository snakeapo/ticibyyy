<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baskets extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'basket_token',
        'coupon_id',
    ];

    public function coupon()
    {
        return $this->hasOne(Coupons::class, 'id', 'coupon_id');
    }

    public function items()
    {
        return $this->hasMany(Basketitems::class, 'basket_no', 'basket_token');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
