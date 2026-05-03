<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasts extends Model
{
    use HasFactory;
    protected $fillable = [
        'ip_address',
        'product_id',
        'product_token',
    ];

    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }
}
