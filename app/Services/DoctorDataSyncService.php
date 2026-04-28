<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\DoctorDepartment;
use App\Models\DoctorSpecialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DoctorDataSyncService
{
    public function syncFromDirectory(string $sourceDir, bool $purge = true): array
    {
        $profiles = $this->loadDoctorProfiles($sourceDir);
        $schedules = $this->loadDoctorSchedules($sourceDir);

        if ($purge) {
            $this->purgeApplicationData();
        }

        $created = 0;
        $scheduled = 0;

        DB::transaction(function () use ($sourceDir, $profiles, $schedules, &$created, &$scheduled) {
            Doctor::query()->forceDelete();
            DoctorSpecialty::query()->delete();
            DoctorDepartment::query()->delete();

            foreach ($profiles as $profile) {
                $schedule = $this->findScheduleForDoctor($profile['name'], $schedules);

                $specialtyName = $this->resolveSpecialtyName($profile, $schedule);
                $departmentName = $this->resolveDepartmentName($profile, $schedule, $specialtyName);

                $specialty = DoctorSpecialty::firstOrCreate(
                    ['name' => $specialtyName],
                    [
                        'slug' => Str::slug($specialtyName),
                        'status' => true,
                        'sort_order' => 0,
                    ]
                );

                $department = DoctorDepartment::firstOrCreate(
                    ['name' => $departmentName],
                    [
                        'slug' => Str::slug($departmentName),
                        'status' => true,
                        'sort_order' => 0,
                    ]
                );

                $imagePath = $this->copyDoctorImage($sourceDir, $profile['name']);

                Doctor::create([
                    'code' => doctor_code(),
                    'doctor_specialty_id' => $specialty->id,
                    'doctor_department_id' => $department->id,
                    'name' => $profile['name'],
                    'slug' => Str::slug($profile['name']) . '-' . Str::lower(Str::random(6)),
                    'phone' => $this->resolvePhoneForDoctor($created),
                    'email' => 'doctor@iphcbd.com',
                    'commission' => 0,
                    'consultation_fee' => 0,
                    'video_consultation_fee' => null,
                    'video_consultation_available' => false,
                    'address' => $profile['hospital'] ?: 'Imperial Private Health Care BD Limited',
                    'designation' => $profile['designation'],
                    'qualification' => $profile['qualification'],
                    'experience_years' => null,
                    'bio' => $profile['description'] ?: null,
                    'image' => $imagePath,
                    'schedule_branch' => $schedule['branch'] ?? null,
                    'schedule_consultant' => $schedule['consultant'] ?? null,
                    'schedule_days' => $schedule['day'] ?? null,
                    'schedule_time' => $schedule['time'] ?? null,
                    'status' => true,
                ]);

                $created++;
                if ($schedule) {
                    $scheduled++;
                }
            }
        });

        return [
            'profiles_count' => count($profiles),
            'schedule_count' => count($schedules),
            'created_count' => $created,
            'scheduled_count' => $scheduled,
        ];
    }

    public function purgeApplicationData(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            foreach ([
                'health_package_booking_payments',
                'membership_plan_booking_payments',
                'group_test_results',
                'group_tests',
                'groups',
                'booking_services',
                'bookings',
                'doctor_consultation_bookings',
                'health_package_bookings',
                'membership_plan_bookings',
                'patient_otps',
                'visits',
                'expenses',
                'patients',
                'doctors',
                'doctor_specialties',
                'doctor_departments',
            ] as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    protected function loadDoctorProfiles(string $sourceDir): array
    {
        $file = $sourceDir . DIRECTORY_SEPARATOR . 'doctors.xlsx';
        $rows = IOFactory::load($file)->getActiveSheet()->toArray(null, true, true, true);
        $profiles = [];

        foreach ($rows as $index => $row) {
            $name = trim((string) ($row['C'] ?? ''));
            if ($index <= 1 || $name === '') {
                continue;
            }

            $profiles[] = [
                'name' => $name,
                'qualification' => trim((string) ($row['D'] ?? '')),
                'designation' => trim((string) ($row['E'] ?? '')),
                'hospital' => trim((string) ($row['F'] ?? '')),
                'description' => trim((string) ($row['G'] ?? '')),
            ];
        }

        return $profiles;
    }

    protected function loadDoctorSchedules(string $sourceDir): array
    {
        $file = $sourceDir . DIRECTORY_SEPARATOR . 'Doctors Schedule.xlsx';
        $rows = IOFactory::load($file)->getActiveSheet()->toArray(null, true, true, true);
        $branch = trim((string) ($rows[3]['A'] ?? ''));
        $branch = str_contains($branch, ':') ? trim(explode(':', $branch, 2)[1]) : $branch;
        $schedules = [];

        foreach ($rows as $index => $row) {
            $name = trim((string) ($row['B'] ?? ''));
            if ($index <= 4 || $name === '') {
                continue;
            }

            $schedules[] = [
                'name' => $name,
                'consultant' => trim((string) ($row['C'] ?? '')),
                'day' => trim((string) ($row['D'] ?? '')),
                'time' => trim((string) ($row['E'] ?? '')),
                'branch' => $branch ?: 'Banglamotor',
            ];
        }

        return $schedules;
    }

    protected function findScheduleForDoctor(string $doctorName, array $schedules): ?array
    {
        $aliases = [
            'prof dr md shahid hossain' => ['prof dr shahid hossen'],
            'dr khwaja sawda tabassum' => ['dr sawda tabassum'],
            'dr khondker mahmudul hakim' => ['dr mahmudul hakim'],
            'dr shahid md nokib' => ['dr shahid md nokib'],
        ];

        $normalizedDoctor = $this->normalizeDoctorName($doctorName);
        $acceptableNames = array_merge([$normalizedDoctor], $aliases[$normalizedDoctor] ?? []);

        foreach ($schedules as $schedule) {
            if (in_array($this->normalizeDoctorName($schedule['name']), $acceptableNames, true)) {
                return $schedule;
            }
        }

        return null;
    }

    protected function normalizeDoctorName(string $value): string
    {
        $value = Str::lower($value);
        $value = str_replace(['.', ',', '-', '&'], ' ', $value);
        $value = preg_replace('/\bprofessor\b/', 'prof', $value);
        $value = preg_replace('/\s+/', ' ', $value ?? '');

        return trim($value);
    }

    protected function resolveSpecialtyName(array $profile, ?array $schedule): string
    {
        $source = $schedule['consultant'] ?? $profile['designation'] ?? 'General Medicine';
        $source = trim($source);

        $map = [
            'general surgeon' => 'General Surgery',
            'medicine' => 'Medicine',
            'psychiatrist' => 'Psychiatry',
            'dermatologist' => 'Dermatology',
            'ent' => 'ENT',
            'nephrology' => 'Nephrology',
            'general physician' => 'General Medicine',
            'ophthalmology' => 'Ophthalmology',
            'gynaecology' => 'Gynaecology',
            'pulmonology' => 'Pulmonology',
            'dentist' => 'Dentistry',
            'pediatrician' => 'Pediatrics',
            'cardiologist' => 'Cardiology',
            'cardiology' => 'Cardiology',
            'sonologist' => 'Sonology',
            'counselor' => 'Clinical Psychology',
            'oral & maxillofacial surgery' => 'Oral & Maxillofacial Surgery',
            'thoracic surgery' => 'Thoracic Surgery',
            'orthopedics' => 'Orthopedics',
        ];

        $normalized = Str::lower($source);
        foreach ($map as $needle => $label) {
            if (str_contains($normalized, $needle)) {
                return $label;
            }
        }

        if (str_contains($normalized, 'consultant - ')) {
            return Str::title(trim(Str::after($source, 'Consultant - ')));
        }

        return Str::title($source ?: 'General Medicine');
    }

    protected function resolveDepartmentName(array $profile, ?array $schedule, string $specialtyName): string
    {
        $source = $profile['designation'] ?: ($schedule['consultant'] ?? $specialtyName);
        $normalized = Str::lower($source);

        $map = [
            'medicine' => 'Medicine',
            'surgery' => 'Surgery',
            'cardio' => 'Cardiology',
            'psychi' => 'Psychiatry',
            'derma' => 'Dermatology',
            'nephro' => 'Nephrology',
            'ent' => 'ENT',
            'ophthal' => 'Ophthalmology',
            'gynae' => 'Gynaecology',
            'pulmon' => 'Pulmonology',
            'dent' => 'Dentistry',
            'pediatric' => 'Pediatrics',
            'thoracic' => 'Thoracic Surgery',
            'ortho' => 'Orthopedics',
            'psychology' => 'Clinical Psychology',
            'sonology' => 'Sonology',
        ];

        foreach ($map as $needle => $label) {
            if (str_contains($normalized, $needle)) {
                return $label;
            }
        }

        return $specialtyName;
    }

    protected function copyDoctorImage(string $sourceDir, string $doctorName): ?string
    {
        $source = $sourceDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $doctorName . '.jpg';
        if (!File::exists($source)) {
            return null;
        }

        $targetDir = public_path('uploads/doctors');
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $targetName = Str::slug($doctorName) . '.jpg';
        $target = $targetDir . DIRECTORY_SEPARATOR . $targetName;
        File::copy($source, $target);

        return 'uploads/doctors/' . $targetName;
    }

    protected function resolvePhoneForDoctor(int $index): string
    {
        return $index % 2 === 0 ? '01332556541' : '01335100543';
    }
}
