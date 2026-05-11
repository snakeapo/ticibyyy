<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'sub_category',
        'brand',
        'price',
        'sale_price',
        'difference',
        'stock',
        'image',
        'variant',
        'feature',
        'installment',
        'our_choice',
        'best_selling',
        'has_return',
        'has_exchange',
        'whatsapp_order_enabled',
        'product_token',
        'meta_title',
        'meta_keyw',
        'meta_desc',
        'status',
    ];

    protected $casts = [
        'has_return' => 'boolean',
        'has_exchange' => 'boolean',
        'whatsapp_order_enabled' => 'boolean',
    ];

    public function getCategory()
    {
        return $this->hasOne('\App\Models\Categories','id','category');
    }

    public function getSubCategory()
    {
        return $this->hasOne('\App\Models\Subcategories','id','sub_category');
    }

    public function getBrand()
    {
        return $this->hasOne('\App\Models\Brands','id','brand');
    }


    public function relatedProducts()
    {
        return $this->belongsToMany(self::class, 'product_related_products', 'product_id', 'related_product_id')->withTimestamps();
    }

    public function relatedToProducts()
    {
        return $this->belongsToMany(self::class, 'product_related_products', 'related_product_id', 'product_id')->withTimestamps();
    }

    public function collections()
    {
        return $this->belongsToMany(Collections::class, 'collection_product', 'product_id', 'collection_id')->withTimestamps();
    }

}
