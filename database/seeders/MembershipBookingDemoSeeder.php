<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use App\Models\MembershipPlanBooking;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class MembershipBookingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $plans = MembershipPlan::where('status', true)->where('show_on_frontend', true)->take(4)->get();

        if ($plans->isEmpty()) {
            return;
        }

        $demoPatients = [
            [
                'name' => 'Shakil Ahmed',
                'phone' => '01720000001',
                'email' => 'demo.member1@example.com',
                'dob' => '1992-05-14',
                'status' => 'pending',
            ],
            [
                'name' => 'Nusrat Jahan',
                'phone' => '01720000002',
                'email' => 'demo.member2@example.com',
                'dob' => '1988-11-22',
                'status' => 'confirmed',
            ],
            [
                'name' => 'Tanvir Hasan',
                'phone' => '01720000003',
                'email' => 'demo.member3@example.com',
                'dob' => '1995-01-09',
                'status' => 'completed',
            ],
            [
                'name' => 'Moumita Roy',
                'phone' => '01720000004',
                'email' => 'demo.member4@example.com',
                'dob' => '1990-07-30',
                'status' => 'cancelled',
            ],
        ];

        foreach ($demoPatients as $i => $entry) {
            $patient = Patient::firstOrCreate(
                ['email' => strtolower($entry['email'])],
                [
                    'code' => patient_code(),
                    'name' => $entry['name'],
                    'gender' => 'male',
                    'dob' => $entry['dob'],
                    'phone' => $entry['phone'],
                ]
            );

            $plan = $plans[$i % $plans->count()];
            $preferredStart = now()->addDays(($i + 1) * 2)->format('Y-m-d');

            MembershipPlanBooking::updateOrCreate(
                [
                    'membership_plan_id' => $plan->id,
                    'email' => strtolower($entry['email']),
                ],
                [
                    'patient_id' => $patient->id,
                    'patient_name' => $entry['name'],
                    'phone' => $entry['phone'],
                    'dob' => $entry['dob'],
                    'preferred_start_date' => $preferredStart,
                    'notes' => 'Demo membership booking for admin panel preview.',
                    'status' => $entry['status'],
                ]
            );
        }
    }
}
