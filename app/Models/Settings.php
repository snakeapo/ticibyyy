<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_title',
        'meta_desc',
        'meta_keyw',
        'mail_address',
        'phone',
        'whatsapp',
        'address',
        'footer',
        'footer_desc',
        'logo',
        'light_logo',
        'favicon',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
        'linkedin',
        'pinterest',
        'live_support',
        'google_analystics',
        'google_play',
        'app_store',
        'google_maps',
        'google_place_id',
        'google_api_key',
        'google_client_id',
        'google_client_secret',
        'google_redirect_uri',
        'facebook_client_id',
        'facebook_client_secret',
        'facebook_redirect_uri',
        'referance_earning',
        'min_widthdraw',
        'free_cargo',
        'paytr_id',
        'paytr_salt',
        'paytr_key',
    ];
}
