<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_title',
        'brand_slug',
        'brand_image',
        'meta_title',
        'meta_keyw',
        'meta_desc',
    ];
}
