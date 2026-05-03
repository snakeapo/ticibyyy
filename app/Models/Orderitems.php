<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitems extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'product_token',
        'order_token',
        'variant_token',
        'total',
        'quantity',
    ];

    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }
    public function getVariant()
    {
        return $this->hasOne('App\Models\Productvars','id','variant_token');
    }
}
