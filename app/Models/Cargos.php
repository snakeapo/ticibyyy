<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    use HasFactory;

    protected $fillable = [
        'cargo_title',
        'cargo_price',
        'cargo_image',
        'cargo_time',
    ];
}
