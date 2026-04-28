<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchGallery extends Model
{
    protected $table = 'branch_gallery';

    protected $fillable = [
        'name',
        'image',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
