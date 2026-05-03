<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'order_no',
        'order_note',
        'user_address',
        'total',
        'cargo',
        'payment_status',
        'payment_system',
        'comment',
        'status',
    ];

    //User
    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function getCargo()
    {
        return $this->hasOne('App\Models\Cargos','id','cargo');
    }

    public function items()
    {
        return $this->hasMany(Orderitems::class, 'order_token', 'order_no');
    }

}
