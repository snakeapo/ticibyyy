<?php

if (!function_exists('greeting')) {
    function greeting()
    {
        $hour = now()->hour;

        if ($hour >= 5 && $hour < 12) {
            return 'Günaydın';
        } elseif ($hour >= 12 && $hour < 17) {
            return 'Tünaydın';
        } elseif ($hour >= 17 && $hour < 21) {
            return 'İyi akşamlar';
        } else {
            return 'İyi geceler';
        }
    }
}
