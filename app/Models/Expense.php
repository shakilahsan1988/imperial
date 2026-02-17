<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Expense extends Model
{
    use LogsActivity;

    protected $fillable = [
        'amount',
        'description',
        'date',
        'expense_category_id',
        'doctor_id',
    ];

    /**
     * Get the category associated with the expense.
     * Includes trashed categories if applicable.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id')->withTrashed();
    }

    /**
     * Get the doctor associated with the expense.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    /**
     * Configure the activity log options for Spatie v4.
     * Replaces the legacy getDescriptionForEvent method.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('expense')
            ->setDescriptionForEvent(fn(string $eventName) => "Expense was {$eventName}");
    }
}