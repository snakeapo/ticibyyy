<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annons extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'annons_desc',
        'status',
    ];
}
