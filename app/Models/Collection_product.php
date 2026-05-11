<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection_product extends Model
{
    use HasFactory;
    protected $table = 'collection_product';

    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }
}
