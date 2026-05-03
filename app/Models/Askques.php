<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Askques extends Model
{
    use HasFactory;
    protected $fillable = [
        'ask',
        'answer',
        'product_id',
        'product_token',
        'answer_time',
        'user_id',
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
}
