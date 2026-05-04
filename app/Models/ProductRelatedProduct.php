<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRelatedProduct extends Model
{
    use HasFactory;

    protected $table = 'product_related_products';

    protected $fillable = [
        'product_id',
        'related_product_id',
    ];
}
