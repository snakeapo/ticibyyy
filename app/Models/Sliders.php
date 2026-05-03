<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    use HasFactory;
    protected $fillable = [
        'slider_title',
        'slider_desc',
        'slider_image',
        'slider_button',
        'slider_link',
        'status',
    ];
}
