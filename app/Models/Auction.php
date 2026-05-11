<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'current_item_id', 'created_by', 'requires_balance'];

    protected $casts = [
        'requires_balance' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(AuctionItem::class)->orderBy('sort_order');
    }

    public function currentItem()
    {
        return $this->belongsTo(AuctionItem::class, 'current_item_id');
    }
}
