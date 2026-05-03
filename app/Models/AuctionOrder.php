<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'auction_item_id',
        'user_id',
        'product_id',
        'order_no',
        'final_price',
        'address_snapshot',
        'win_type',
        'status',
    ];

    protected $casts = [
        'final_price' => 'decimal:2',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function item()
    {
        return $this->belongsTo(AuctionItem::class, 'auction_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
