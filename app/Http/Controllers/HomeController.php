<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function change_locale($locale)
    {
        $supportedLocales = ['en', 'bn'];
        
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }

        session()->put('locale', $locale);
        
        // Load translations for JavaScript
        $jsonFile = resource_path('lang/' . $locale . '.json');
        if (File::exists($jsonFile)) {
            $trans = File::get($jsonFile);
            session()->put('trans', $trans);
        }
        
        $language = Language::where('iso', $locale)->first();
        if ($language) {
            session()->put('rtl', $language['rtl'] ?? false);
        }

        return redirect()->back();
    }
}
