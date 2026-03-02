<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'layout_type',
        'hero_title_html',
        'hero_description',
        'hero_image',
        'body_html',
        'settings_json',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'settings_json' => 'array',
        'status' => 'boolean',
    ];
}

