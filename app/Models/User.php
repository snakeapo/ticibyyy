<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'balance',
        'identy',
        'avatar',
        'role',
        'sex',
        'user_phone',
        'referance',
        'google_id',
        'facebook_id',
        'notify_new_products',
        'notify_stock_updates',
        'notify_order_updates',
        'notify_coupon_updates',
        'notify_price_drops',
        'notify_question_answers',
        'notify_abandoned_cart',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
        'notify_new_products' => 'boolean',
        'notify_stock_updates' => 'boolean',
        'notify_order_updates' => 'boolean',
        'notify_coupon_updates' => 'boolean',
        'notify_price_drops' => 'boolean',
        'notify_question_answers' => 'boolean',
        'notify_abandoned_cart' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }
}
