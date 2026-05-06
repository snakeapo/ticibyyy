<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productcoms extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_token',
        'user_id',
        'order_id',
        'comment',
        'point',
        'answer',
        'answer_time',
        'image',
        'status',
    ];

    //User
    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    //Product
    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }
    public function getOrder()
    {
        return $this->hasOne('App\Models\Orders','id','order_id');
    }

    public function items()
    {
        return $this->hasMany(Orderitems::class, 'order_token', 'order_no');
    }
}
