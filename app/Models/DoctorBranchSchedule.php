<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorBranchSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'branch_id',
        'consultant',
        'schedule_days',
        'schedule_time',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
