<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_surname',
        'account',
        'iban',
        'bank_name',
        'user_id',
        'total',
        'status',
    ];

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
