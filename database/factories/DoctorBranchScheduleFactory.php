<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorBranchSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DoctorBranchSchedule>
 */
class DoctorBranchScheduleFactory extends Factory
{
    protected $model = DoctorBranchSchedule::class;

    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'branch_id' => Branch::factory(),
            'consultant' => 'Medicine',
            'schedule_days' => 'Sat, Mon, Wed',
            'schedule_time' => '10:00 AM - 01:00 PM',
        ];
    }
}
