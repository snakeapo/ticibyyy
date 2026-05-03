<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    use HasFactory;

    protected $fillable = ['auction_item_id', 'user_id', 'amount', 'status'];

    protected $casts = ['amount' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
