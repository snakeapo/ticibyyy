<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collections extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'collection_product', 'collection_id', 'product_id')->withTimestamps();
    }
}
