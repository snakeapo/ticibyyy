<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_title',
        'blog_desc',
        'blog_slug',
        'category_id',
        'image',
        'blog_tag',
        'meta_title',
        'meta_keyw',
        'meta_desc',
    ];

    public function getCategory()
    {
        return $this->hasOne('App\Models\Blogcats','id','category_id');
    }
}
