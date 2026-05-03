<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    protected $fillable = [
        'page_title',
        'page_desc',
        'page_slug',
        'meta_title',
        'meta_keyw',
        'meta_desc',
    ];
}
