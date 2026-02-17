<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;

class Locale
{
    public function handle($request, Closure $next)
    {
        $supportedLocales = ['en', 'bn'];
        $locale = session('locale', 'en');

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        // Load translations for JavaScript
        if (!session()->has('trans')) {
            $jsonFile = resource_path('lang/' . $locale . '.json');
            if (File::exists($jsonFile)) {
                $trans = File::get($jsonFile);
                session()->put('trans', $trans);
            } else {
                session()->put('trans', json_encode([]));
            }
        }

        view()->share([
            'languages' => collect($supportedLocales)->map(function($loc) {
                return (object)['iso' => $loc, 'name' => $loc === 'en' ? 'English' : 'বাংলা'];
            })
        ]);

        return $next($request);
    }
}
