<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryGroup extends Model
{
    protected $fillable = [
        'name',
        'sort_order',
    ];

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order')->orderBy('id');
    }
}
