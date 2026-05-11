<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'id' => '1',
            'meta_title' => 'Softby - Eticaret',
            'meta_desc' => 'Softby eticaret açıklaması',
            'meta_keyw' => 'softby,eticaret,yeni nesil,laravel',
            'mail_address' => 'info@softby.net',
            'phone' => '+90 537 681 80 46',
            'whatsapp' => '+90 537 681 80 46',
            'address' => '5 Nisan Mahallesi 2006.Sokak',
            'footer'=> 'Softby - Tüm Hakları Saklıdır.',
            'footer_desc'=> 'Softby yeni nesil eticaret sistemleri ile eticaret alanındaki kazanım ve başarıları güvenle arttıran modern ve basit kullanışlı eticaret sistemidir, kullanılan alt yapı laravel olup 10.versiy',
            'logo'=> 'logo.png',
            'light_logo'=> 'light.png',
            'favicon'=> 'favicon.png',
            'facebook'=> 'https://softby.net',
            'twitter'=> 'https://softby.net',
            'youtube'=> 'https://softby.net',
            'instagram'=> 'https://softby.net',
            'pinterest'=> 'https://softby.net',
            'linkedin'=> 'https://softby.net',
            'live_support'=> '1',
            'google_analystics'=> '1',
            'google_play'=> '1',
            'app_store'=> '1',
            'google_maps'=> 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1329.1137186139968!2d36.877558762277694!3d37.597852326701926!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152ddd595a387be5%3A0xdd31a25ab14a8c1b!2zU29mdGJ5IC0gV2ViIFlhesSxbMSxbSDDh8O2esO8bWxlcmk!5e0!3m2!1str!2str!4v1714561448188!5m2!1str!2str',
            'google_place_id'=> '1',
            'google_api_key'=> '1',
            'google_client_id'=> null,
            'google_client_secret'=> null,
            'google_redirect_uri'=> null,
            'facebook_client_id'=> null,
            'facebook_client_secret'=> null,
            'facebook_redirect_uri'=> null,
            'referance_earning'=> '20',
            'min_widthdraw'=> '250',
            'free_cargo'=> '2500',
            'paytr_id'=> '1',
            'paytr_salt'=> '1',
            'paytr_key'=> '1',
            'cash_on_delivery_enabled' => true,
        ]);
    }
}
