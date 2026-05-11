<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productvars extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_token',
        'variant_image',
        'variant_name',
        'variant_type',
        'parent_variant_type',
        'parent_variant_name',
        'variant_price',
        'variant_stock',
        'is_color',
    ];

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
