<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_title',
        'category_slug',
        'category_image',
        'meta_title',
        'meta_keyw',
        'meta_desc',
        'home_show',
    ];
    public function subcategories()
    {
        return $this->hasMany(Subcategories::class, 'top_category');
    }
}
