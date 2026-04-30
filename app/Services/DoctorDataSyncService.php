<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\DoctorBranchSchedule;
use App\Models\DoctorDepartment;
use App\Models\DoctorSpecialty;
use App\Models\Branch;
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
        $branchMap = $this->loadBranchMap();

        if ($purge) {
            $this->purgeApplicationData();
        }

        $created = 0;
        $matchedProfiles = 0;
        $avatarFallbacks = 0;

        DB::transaction(function () use ($sourceDir, $profiles, $schedules, $branchMap, &$created, &$matchedProfiles, &$avatarFallbacks) {
            Doctor::query()->forceDelete();
            DoctorBranchSchedule::query()->delete();
            DoctorSpecialty::query()->delete();
            DoctorDepartment::query()->delete();
            $doctorsByName = [];

            foreach ($schedules as $schedule) {
                $profile = $this->findProfileForSchedule($schedule, $profiles);
                $doctorName = $profile['name'] ?? $schedule['name'];
                $normalizedDoctorName = $this->normalizeDoctorName($doctorName);
                $specialtyName = $this->resolveSpecialtyName($profile ?? [], $schedule);
                $departmentName = $this->resolveDepartmentName($profile ?? [], $schedule, $specialtyName);

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

                $doctor = $doctorsByName[$normalizedDoctorName] ?? null;
                if (! $doctor) {
                    $hasNamedImage = $this->hasNamedDoctorImage($sourceDir, $doctorName, $schedule['name']);
                    $imagePath = $this->copyDoctorImage($sourceDir, $doctorName, $schedule['name']);

                    $doctor = Doctor::create([
                        'code' => doctor_code(),
                        'doctor_specialty_id' => $specialty->id,
                        'doctor_department_id' => $department->id,
                        'branch_id' => null,
                        'name' => $doctorName,
                        'slug' => Str::slug($doctorName) . '-' . Str::lower(Str::random(6)),
                        'phone' => $this->resolvePhoneForDoctor($created),
                        'email' => 'doctor@iphcbd.com',
                        'commission' => 0,
                        'consultation_fee' => 0,
                        'video_consultation_fee' => null,
                        'video_consultation_available' => false,
                        'address' => ($profile['hospital'] ?? null) ?: 'Imperial Private Health Care BD Limited',
                        'designation' => ($profile['designation'] ?? null) ?: ($schedule['consultant'] ?? null),
                        'qualification' => $profile['qualification'] ?? null,
                        'experience_years' => null,
                        'bio' => ($profile['description'] ?? null) ?: null,
                        'image' => $imagePath,
                        'schedule_branch' => null,
                        'schedule_consultant' => null,
                        'schedule_days' => null,
                        'schedule_time' => null,
                        'status' => true,
                    ]);

                    $doctorsByName[$normalizedDoctorName] = $doctor;
                    $created++;

                    if ($profile) {
                        $matchedProfiles++;
                    }

                    if (! $hasNamedImage) {
                        $avatarFallbacks++;
                    }
                } else {
                    $doctor->update([
                        'doctor_specialty_id' => $doctor->doctor_specialty_id ?: $specialty->id,
                        'doctor_department_id' => $doctor->doctor_department_id ?: $department->id,
                        'address' => $doctor->address ?: (($profile['hospital'] ?? null) ?: 'Imperial Private Health Care BD Limited'),
                        'designation' => $doctor->designation ?: (($profile['designation'] ?? null) ?: ($schedule['consultant'] ?? null)),
                        'qualification' => $doctor->qualification ?: ($profile['qualification'] ?? null),
                        'bio' => $doctor->bio ?: (($profile['description'] ?? null) ?: null),
                    ]);
                }

                $branchId = $branchMap[$this->normalizeBranchName($schedule['branch'])] ?? null;
                if ($branchId) {
                    DoctorBranchSchedule::updateOrCreate(
                        [
                            'doctor_id' => $doctor->id,
                            'branch_id' => $branchId,
                        ],
                        [
                            'consultant' => $schedule['consultant'] ?? null,
                            'schedule_days' => $schedule['day'] ?? null,
                            'schedule_time' => $schedule['time'] ?? null,
                        ]
                    );
                }
            }
        });

        return [
            'profiles_count' => count($profiles),
            'schedule_count' => count($schedules),
            'created_count' => $created,
            'matched_profile_count' => $matchedProfiles,
            'avatar_fallback_count' => $avatarFallbacks,
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
                'doctor_branch_schedules',
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

            $profile = [
                'name' => $name,
                'qualification' => trim((string) ($row['D'] ?? '')),
                'designation' => trim((string) ($row['E'] ?? '')),
                'hospital' => trim((string) ($row['F'] ?? '')),
                'description' => trim((string) ($row['G'] ?? '')),
            ];

            $profiles[$this->normalizeDoctorName($name)] = $profile;
        }

        return $profiles;
    }

    protected function loadDoctorSchedules(string $sourceDir): array
    {
        $schedules = [];

        foreach ($this->resolveScheduleFiles($sourceDir) as $file) {
            $rows = IOFactory::load($file)->getActiveSheet()->toArray(null, true, true, true);
            $rawBranch = trim((string) ($rows[3]['A'] ?? ''));
            $rawBranch = str_contains($rawBranch, ':') ? trim(explode(':', $rawBranch, 2)[1]) : $rawBranch;
            $branch = $this->formatBranchLabel($rawBranch ?: pathinfo($file, PATHINFO_FILENAME));

            foreach ($rows as $index => $row) {
                $name = trim((string) ($row['B'] ?? ''));
                if ($index <= 4 || $name === '') {
                    continue;
                }

                $schedules[] = [
                    'name' => $this->cleanDoctorName($name),
                    'consultant' => trim((string) ($row['C'] ?? '')),
                    'day' => trim((string) ($row['D'] ?? '')),
                    'time' => trim((string) ($row['E'] ?? '')),
                    'branch' => $branch,
                ];
            }
        }

        return $schedules;
    }

    protected function findProfileForSchedule(array $schedule, array $profiles): ?array
    {
        $normalizedDoctor = $this->normalizeDoctorName($schedule['name']);

        if (isset($profiles[$normalizedDoctor])) {
            return $profiles[$normalizedDoctor];
        }

        foreach ($this->doctorAliases() as $canonical => $aliases) {
            if ($normalizedDoctor === $canonical || in_array($normalizedDoctor, $aliases, true)) {
                return $profiles[$canonical] ?? null;
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

    protected function resolveScheduleFiles(string $sourceDir): array
    {
        $pattern = $sourceDir . DIRECTORY_SEPARATOR . 'Doctors Schedule*.xlsx';
        $files = File::glob($pattern) ?: [];

        if (empty($files)) {
            $fallback = $sourceDir . DIRECTORY_SEPARATOR . 'Doctors Schedule.xlsx';
            if (File::exists($fallback)) {
                $files[] = $fallback;
            }
        }

        sort($files);

        return $files;
    }

    protected function loadBranchMap(): array
    {
        $map = [];

        foreach (Branch::query()->get(['id', 'name', 'title']) as $branch) {
            foreach (array_filter([$branch->title, $branch->name]) as $value) {
                $map[$this->normalizeBranchName($value)] = $branch->id;
            }
        }

        return $map;
    }

    protected function normalizeBranchName(string $value): string
    {
        $value = Str::lower($value);
        $value = str_replace(['branch', 'imperial private health care (bd) ltd.', 'imperial private healthcare (bd) ltd.'], '', $value);
        $value = str_replace(['(', ')', '.', '-', '_'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value ?? '');

        return trim($value);
    }

    protected function formatBranchLabel(string $value): string
    {
        return match ($this->normalizeBranchName($value)) {
            'banglamotor' => 'Banglamotor',
            'hatirpool' => 'Hatirpool',
            default => Str::title($this->normalizeBranchName($value)),
        };
    }

    protected function cleanDoctorName(string $value): string
    {
        $value = preg_replace('/\s+/', ' ', trim($value));
        $value = preg_replace('/\bDr\.(?=[A-Za-z])/', 'Dr. ', $value);

        return trim($value ?? '');
    }

    protected function doctorAliases(): array
    {
        return [
            'prof dr md shahid hossain' => ['prof dr shahid hossen'],
            'dr khwaja sawda tabassum' => ['dr sawda tabassum'],
            'dr khondker mahmudul hakim' => ['dr mahmudul hakim'],
            'dr shahid md nokib' => ['dr shahid md nokib'],
            'dr md mahfuzur rahman' => ['dr mahfuzur rahman'],
            'dr khaled mahmud arif' => ['dr khaled mahmood arif'],
            'dr golam faysal sarker' => ['dr golam foysal sarkar'],
        ];
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
        $source = ($profile['designation'] ?? null) ?: ($schedule['consultant'] ?? $specialtyName);
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

    protected function copyDoctorImage(string $sourceDir, string $doctorName, ?string $alternateName = null): ?string
    {
        $imageDir = $sourceDir . DIRECTORY_SEPARATOR . 'images';
        $source = $this->resolveDoctorImageSource($imageDir, array_filter([$doctorName, $alternateName]));

        if (! $source) {
            $source = $this->resolveAvatarSource($imageDir, $doctorName);
        }

        $targetDir = public_path('uploads/doctors');
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $extension = pathinfo($source, PATHINFO_EXTENSION) ?: 'jpg';
        $targetName = Str::slug($doctorName) . '.' . Str::lower($extension);
        $target = $targetDir . DIRECTORY_SEPARATOR . $targetName;
        File::copy($source, $target);

        return 'uploads/doctors/' . $targetName;
    }

    protected function resolveDoctorImageSource(string $imageDir, array $candidateNames): ?string
    {
        $normalizedCandidates = [];
        foreach ($candidateNames as $name) {
            if (! $name) {
                continue;
            }

            $normalizedCandidates[] = $this->normalizeDoctorName($name);
        }

        foreach (File::files($imageDir) as $file) {
            if (str_contains(Str::lower($file->getFilename()), 'avatar')) {
                continue;
            }

            if (in_array($this->normalizeDoctorName(pathinfo($file->getFilename(), PATHINFO_FILENAME)), $normalizedCandidates, true)) {
                return $file->getPathname();
            }
        }

        return null;
    }

    protected function resolveAvatarSource(string $imageDir, string $doctorName): string
    {
        $avatar = $this->isLikelyFemaleDoctor($doctorName)
            ? 'female-doctor-avatar.jpg'
            : 'male-doctor-avatar.jpg';

        return $imageDir . DIRECTORY_SEPARATOR . $avatar;
    }

    protected function isLikelyFemaleDoctor(string $doctorName): bool
    {
        $normalized = $this->normalizeDoctorName($doctorName);
        $femaleTokens = [
            'tabassum',
            'marufa',
            'sharmin',
            'syeda',
            'samantha',
            'mohuwa',
            'tanjida',
            'jakiya',
            'junia',
            'jubaiba',
            'jannatul',
            'tania',
            'parvin',
            'beente',
        ];

        foreach ($femaleTokens as $token) {
            if (str_contains($normalized, $token)) {
                return true;
            }
        }

        return false;
    }

    protected function hasNamedDoctorImage(string $sourceDir, string $doctorName, ?string $alternateName = null): bool
    {
        $imageDir = $sourceDir . DIRECTORY_SEPARATOR . 'images';

        return $this->resolveDoctorImageSource($imageDir, array_filter([$doctorName, $alternateName])) !== null;
    }

    protected function resolvePhoneForDoctor(int $index): string
    {
        return $index % 2 === 0 ? '01332556541' : '01335100543';
    }
}
