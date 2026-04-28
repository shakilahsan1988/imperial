<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Branch extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'branches';

    protected $fillable = [
        'name',
        'title',
        'slug',
        'description',
        'address',
        'phone',
        'contact_information',
        'feature_image',
        'google_map_location',
        'lat',
        'lng',
        'zoom_level',
    ];

    public function galleries()
    {
        return $this->hasMany(BranchGallery::class, 'branch_id')->latest('id');
    }

    public function managementTeams()
    {
        return $this->hasMany(TeamMember::class, 'branch_id')->orderBy('sort_order')->orderBy('id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'branch_id')->orderBy('name');
    }

    /**
     * Activity Log (Spatie v4+)
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('branch')
            ->setDescriptionForEvent(fn (string $eventName) => "Branch was {$eventName}");
    }
}
