<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogcats extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_title',
        'category_slug',
        'meta_title',
        'meta_keyw',
        'meta_desc',
    ];
}
