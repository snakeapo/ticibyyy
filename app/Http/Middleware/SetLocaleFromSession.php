<?php

namespace App\Http\Middleware;

use App\Models\Languages;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $defaultLocale = 'tr';
        $locale = (string) $request->session()->get('locale', $defaultLocale);

        $language = Languages::query()->where('language_code', $locale)->first();

        if (!$language) {
            $locale = $defaultLocale;
            $request->session()->put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
