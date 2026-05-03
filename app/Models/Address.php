<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = "address";

    protected $fillable = [
        'address_title',
        'city',
        'town',
        'address',
        'postal_code',
        'phone',
        'address_token',
        'user_id',
    ];
}
