<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basketitems extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_token',
        'variant',
        'user_id',
        'total',
        'coupon',
        'old_total',
        'quantity',
        'basket_no',
    ];

    public function getBasket()
    {
        return $this->hasOne('App\Models\Baskets','basket_token','basket_no');
    }

    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }

    public function getVariant()
    {
        return $this->hasOne('App\Models\Productvars','id','variant');
    }

    public function getCoupon()
    {
        return $this->hasOne('App\Models\Coupons','id','coupon');
    }

    public function getVariantsMulti()
    {
        if (!$this->variant) return collect();

        $ids = explode('-', $this->variant);

        return \App\Models\Productvars::whereIn('id', $ids)->get();
    }
}
