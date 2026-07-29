<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Support\DoctorImagePresenter;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Doctor extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'code',
        'doctor_specialty_id',
        'doctor_department_id',
        'branch_id',
        'name',
        'gender',
        'slug',
        'phone',
        'email',
        'commission',
        'consultation_fee',
        'video_consultation_fee',
        'video_consultation_available',
        'address',
        'designation',
        'qualification',
        'experience_years',
        'bio',
        'image',
        'schedule_branch',
        'schedule_consultant',
        'schedule_days',
        'schedule_time',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'video_consultation_available' => 'boolean',
        'commission' => 'decimal:2',
        'consultation_fee' => 'decimal:2',
        'video_consultation_fee' => 'decimal:2',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * Note: `effective_image_url` is deliberately NOT appended here. Appending
     * it would fire a filesystem check for every row serialized by the admin
     * DataTables endpoint and would silently change the shape of the existing
     * select2 JSON responses. Surfaces that need the resolved URL ask for it
     * explicitly instead.
     */
    protected $appends = ['total', 'paid', 'due'];

    /**
     * Get the groups associated with the doctor.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'doctor_id', 'id');
    }

    /**
     * Get the expenses associated with the doctor.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'doctor_id', 'id');
    }

    public function specialty()
    {
        return $this->belongsTo(DoctorSpecialty::class, 'doctor_specialty_id');
    }

    public function department()
    {
        return $this->belongsTo(DoctorDepartment::class, 'doctor_department_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branchSchedules(): HasMany
    {
        return $this->hasMany(DoctorBranchSchedule::class)->with('branch')->orderBy('branch_id');
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'doctor_branch_schedules')
            ->withPivot(['consultant', 'schedule_days', 'schedule_time'])
            ->withTimestamps()
            ->orderByRaw('coalesce(title, name)');
    }

    public function consultationBookings()
    {
        return $this->hasMany(DoctorConsultationBooking::class, 'doctor_id');
    }

    /**
     * The image this doctor should actually display.
     *
     * Resolves to the personal photo when one exists on disk, and otherwise to
     * the shared avatar for the doctor's gender. Every surface - admin, public,
     * and JSON - must read this rather than `image`, which may be null or may
     * point at a file that is no longer there.
     */
    protected function effectiveImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => DoctorImagePresenter::url($this),
        );
    }

    /**
     * Whether this doctor has a usable personal photo rather than an avatar.
     */
    public function hasPersonalImage(): bool
    {
        return DoctorImagePresenter::hasPersonalImage($this);
    }

    /**
     * Interact with the doctor's total commission.
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->groups->sum('doctor_commission'),
        );
    }

    /**
     * Interact with the doctor's paid amount.
     */
    protected function paid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expenses->sum('amount'),
        );
    }

    /**
     * Interact with the doctor's due amount.
     */
    protected function due(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total - $this->paid,
        );
    }

    /**
     * Configure the activity log options for Spatie v4.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('doctor')
            ->setDescriptionForEvent(fn(string $eventName) => "Doctor was {$eventName}");
    }
}
