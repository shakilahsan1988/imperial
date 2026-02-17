<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'gender',
        'dob',
        'email',
        'phone',
        'address',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['age', 'total', 'paid', 'due'];

    /**
     * Get the diagnostic groups associated with the patient.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'patient_id', 'id');
    }

    /**
     * Interact with the patient's age.
     * Calculated based on Date of Birth (dob).
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->dob) return null;

                $date = new DateTime($this->dob);
                $now = new DateTime();
                $interval = $now->diff($date);

                if ($interval->y == 0) {
                    if ($interval->m == 0) {
                        return $interval->d . " " . __('Days');
                    }
                    return $interval->m . " " . __('Months');
                }
                return $interval->y . " " . __('Years');
            },
        );
    }

    /**
     * Interact with the patient's total bill across all groups.
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->groups->sum('total'),
        );
    }

    /**
     * Interact with the patient's total paid amount.
     */
    protected function paid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->groups->sum('paid'),
        );
    }

    /**
     * Interact with the patient's total due amount.
     */
    protected function due(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->groups->sum('due'),
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
            ->useLogName('patient')
            ->setDescriptionForEvent(fn(string $eventName) => "Patient was {$eventName}");
    }
}