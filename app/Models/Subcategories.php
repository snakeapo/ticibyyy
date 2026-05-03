<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_title',
        'sub_slug',
        'top_category',
        'parent_id',
        'meta_title',
        'meta_keyw',
        'meta_desc',
    ];

    public function getCategory()
    {
        return $this->hasOne('\App\Models\Categories', 'id', 'top_category');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function childrenx()
    {
        return $this->hasMany(Subcategories::class, 'parent_id');
    }
}
