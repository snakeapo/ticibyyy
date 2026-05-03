<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id', 'product_id', 'custom_title', 'custom_description', 'custom_image',
        'custom_images', 'custom_videos',
        'buy_now_price', 'start_price', 'min_increment', 'idle_timeout_seconds', 'status',
        'no_bid_timeout_seconds',
        'winner_user_id', 'winning_bid', 'started_at', 'last_bid_at', 'ended_at', 'sort_order',
    ];

    protected $casts = [
        'buy_now_price' => 'decimal:2',
        'start_price' => 'decimal:2',
        'min_increment' => 'decimal:2',
        'winning_bid' => 'decimal:2',
        'custom_images' => 'array',
        'custom_videos' => 'array',
        'started_at' => 'datetime',
        'last_bid_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function bids()
    {
        return $this->hasMany(AuctionBid::class)->latest();
    }

    public function highestBid()
    {
        return $this->hasOne(AuctionBid::class)->latestOfMany('amount');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function auctionOrder()
    {
        return $this->hasOne(AuctionOrder::class, 'auction_item_id');
    }
}
