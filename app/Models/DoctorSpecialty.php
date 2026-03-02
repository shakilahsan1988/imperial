<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecialty extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'doctor_specialty_id')->orderBy('name');
    }
}
