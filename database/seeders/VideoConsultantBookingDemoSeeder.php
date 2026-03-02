<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use App\Models\MembershipPlanBooking;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class VideoConsultantBookingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $plans = MembershipPlan::where('status', true)
            ->where('show_on_frontend', true)
            ->where('is_video_consultant', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->take(3)
            ->get();

        if ($plans->isEmpty()) {
            return;
        }

        $rows = [
            [
                'name' => 'Video Patient One',
                'phone' => '01730000001',
                'email' => 'video.booking1@example.com',
                'dob' => '1994-02-11',
                'status' => 'pending',
                'notes' => 'Demo consultant booking - pending.',
            ],
            [
                'name' => 'Video Patient Two',
                'phone' => '01730000002',
                'email' => 'video.booking2@example.com',
                'dob' => '1989-09-23',
                'status' => 'confirmed',
                'notes' => 'Demo consultant booking - confirmed.',
            ],
            [
                'name' => 'Video Patient Three',
                'phone' => '01730000003',
                'email' => 'video.booking3@example.com',
                'dob' => '1991-12-05',
                'status' => 'completed',
                'notes' => 'Demo consultant booking - completed.',
            ],
        ];

        foreach ($rows as $i => $row) {
            $patient = Patient::firstOrCreate(
                ['email' => strtolower($row['email'])],
                [
                    'code' => patient_code(),
                    'name' => $row['name'],
                    'gender' => 'male',
                    'dob' => $row['dob'],
                    'phone' => $row['phone'],
                ]
            );

            $plan = $plans[$i % $plans->count()];
            $startDate = now()->addDays($i + 2)->format('Y-m-d');

            MembershipPlanBooking::updateOrCreate(
                [
                    'membership_plan_id' => $plan->id,
                    'email' => strtolower($row['email']),
                ],
                [
                    'patient_id' => $patient->id,
                    'patient_name' => $row['name'],
                    'phone' => $row['phone'],
                    'dob' => $row['dob'],
                    'preferred_start_date' => $startDate,
                    'notes' => $row['notes'],
                    'status' => $row['status'],
                ]
            );
        }
    }
}
