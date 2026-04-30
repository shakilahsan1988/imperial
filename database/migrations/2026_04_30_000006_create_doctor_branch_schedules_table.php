<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_branch_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->string('consultant')->nullable();
            $table->string('schedule_days')->nullable();
            $table->string('schedule_time')->nullable();
            $table->timestamps();
            $table->unique(['doctor_id', 'branch_id']);
        });

        $this->migrateExistingDoctorSchedules();
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_branch_schedules');
    }

    protected function migrateExistingDoctorSchedules(): void
    {
        if (! Schema::hasTable('doctors') || ! Schema::hasTable('branches')) {
            return;
        }

        $branches = DB::table('branches')->get(['id', 'name', 'title']);
        $branchMap = [];

        foreach ($branches as $branch) {
            foreach (array_filter([$branch->title, $branch->name]) as $value) {
                $branchMap[$this->normalizeBranchName($value)] = $branch->id;
            }
        }

        $doctors = DB::table('doctors')->orderBy('id')->get();
        $grouped = [];

        foreach ($doctors as $doctor) {
            $grouped[$this->normalizeDoctorName($doctor->name)][] = $doctor;
        }

        foreach ($grouped as $items) {
            $keeper = array_shift($items);

            $this->upsertScheduleForDoctor($keeper->id, $keeper, $branchMap);
            $this->clearLegacyDoctorFields($keeper->id);

            foreach ($items as $duplicate) {
                $this->mergeDoctorRow($keeper->id, $duplicate);
                $this->upsertScheduleForDoctor($keeper->id, $duplicate, $branchMap);
                $this->clearLegacyDoctorFields($duplicate->id);
                DB::table('doctors')->where('id', $duplicate->id)->delete();
            }
        }
    }

    protected function mergeDoctorRow(int $keeperId, object $duplicate): void
    {
        $keeper = DB::table('doctors')->where('id', $keeperId)->first();
        if (! $keeper) {
            return;
        }

        $fields = [
            'qualification',
            'designation',
            'address',
            'bio',
            'image',
            'experience_years',
            'doctor_specialty_id',
            'doctor_department_id',
        ];

        $updates = [];
        foreach ($fields as $field) {
            $current = $keeper->{$field} ?? null;
            $incoming = $duplicate->{$field} ?? null;

            if (($current === null || $current === '') && $incoming !== null && $incoming !== '') {
                $updates[$field] = $incoming;
            }
        }

        if (! empty($updates)) {
            DB::table('doctors')->where('id', $keeperId)->update($updates);
        }

        foreach (['doctor_consultation_bookings', 'groups', 'expenses'] as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->where('doctor_id', $duplicate->id)->update(['doctor_id' => $keeperId]);
            }
        }
    }

    protected function upsertScheduleForDoctor(int $doctorId, object $doctor, array $branchMap): void
    {
        $branchId = $doctor->branch_id;

        if (! $branchId && ! empty($doctor->schedule_branch)) {
            $branchId = $branchMap[$this->normalizeBranchName($doctor->schedule_branch)] ?? null;
        }

        if (! $branchId) {
            return;
        }

        DB::table('doctor_branch_schedules')->updateOrInsert(
            [
                'doctor_id' => $doctorId,
                'branch_id' => $branchId,
            ],
            [
                'consultant' => $doctor->schedule_consultant,
                'schedule_days' => $doctor->schedule_days,
                'schedule_time' => $doctor->schedule_time,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    protected function clearLegacyDoctorFields(int $doctorId): void
    {
        DB::table('doctors')->where('id', $doctorId)->update([
            'branch_id' => null,
            'schedule_branch' => null,
            'schedule_consultant' => null,
            'schedule_days' => null,
            'schedule_time' => null,
        ]);
    }

    protected function normalizeDoctorName(?string $value): string
    {
        $value = Str::lower((string) $value);
        $value = str_replace(['.', ',', '-', '&'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value ?? '');

        return trim($value);
    }

    protected function normalizeBranchName(?string $value): string
    {
        $value = Str::lower((string) $value);
        $value = str_replace(['branch', 'imperial private health care (bd) ltd.', 'imperial private healthcare (bd) ltd.'], '', $value);
        $value = str_replace(['(', ')', '.', '-', '_'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value ?? '');

        return trim($value);
    }
};
