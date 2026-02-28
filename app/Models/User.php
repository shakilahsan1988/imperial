<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable,HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function can($ability, $arguments = [])
    {
        if ($this->id == 1) {
            return true;
        }

        return $this->hasPermission($ability);
    }

    /**
     * Corrected Relationship: Many-to-Many with Role
     *
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Custom method to check permissions via roles
     *
     */
    public function hasPermission($permissionKey)
    {
        // MD. Shakil Ahsan (Super Admin) has all permissions
        if ($this->id == 1) {
            return true;
        }

        return $this->roles->flatMap->permissions->pluck('key')->contains($permissionKey);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->roles->pluck('name')->contains($roleName);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('user')
            ->setDescriptionForEvent(fn(string $eventName) => "User was {$eventName}");
    }
}