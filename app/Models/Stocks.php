<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_token',
        'email',
    ];

    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }
}
