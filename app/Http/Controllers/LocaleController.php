<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        $locale = strtolower($locale);

        $exists = Languages::query()->where('language_code', $locale)->exists();

        if ($exists) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return back();
    }
}
