<?php

namespace App\Http\Controllers;

use App\Models\Page;

class DynamicPageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('status', true)->where('slug', $slug)->firstOrFail();

        return view('frontend.dynamic-page', compact('page'));
    }
}

