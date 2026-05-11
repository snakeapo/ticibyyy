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
        'cargo_id',
        'cargo_price',
        'payment_method',
        'checkout_completed_at',
        'win_type',
        'status',
    ];

    protected $casts = [
        'final_price' => 'decimal:2',
        'cargo_price' => 'decimal:2',
        'checkout_completed_at' => 'datetime',
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

    public function cargo()
    {
        return $this->belongsTo(Cargos::class, 'cargo_id');
    }

    public function getTotalAmountAttribute(): float
    {
        return (float) $this->final_price + (float) ($this->cargo_price ?? 0);
    }

    public function isCheckoutCompleted(): bool
    {
        return !is_null($this->checkout_completed_at);
    }
}
