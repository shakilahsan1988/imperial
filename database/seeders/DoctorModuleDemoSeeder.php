<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorConsultationSlot;
use App\Models\DoctorDepartment;
use App\Models\DoctorSpecialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorModuleDemoSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::query()->first();

        if (!$branch) {
            $branch = Branch::create([
                'name' => 'Imperial Main Hub',
                'address' => 'Dhaka, Bangladesh',
                'phone' => '01700000000',
            ]);
        }

        $specialties = [
            ['name' => 'Interventional Cardiology', 'sort_order' => 1],
            ['name' => 'Clinical Nutrition', 'sort_order' => 2],
            ['name' => 'Neurology', 'sort_order' => 3],
            ['name' => 'Pulmonology', 'sort_order' => 4],
            ['name' => 'Acupuncture Therapy', 'sort_order' => 5],
        ];

        foreach ($specialties as $item) {
            DoctorSpecialty::updateOrCreate(
                ['name' => $item['name']],
                [
                    'slug' => Str::slug($item['name']) . '-demo',
                    'description' => $item['name'] . ' specialty',
                    'sort_order' => $item['sort_order'],
                    'status' => true,
                ]
            );
        }

        $departments = [
            ['name' => 'Cardiology', 'sort_order' => 1],
            ['name' => 'Medicine', 'sort_order' => 2],
            ['name' => 'Neurology', 'sort_order' => 3],
            ['name' => 'Pulmonology', 'sort_order' => 4],
            ['name' => 'Acupuncture', 'sort_order' => 5],
        ];

        foreach ($departments as $item) {
            DoctorDepartment::updateOrCreate(
                ['name' => $item['name']],
                [
                    'slug' => Str::slug($item['name']) . '-demo',
                    'description' => $item['name'] . ' department',
                    'sort_order' => $item['sort_order'],
                    'status' => true,
                ]
            );
        }

        $slots = [
            ['label' => '09:00 AM - 09:30 AM', 'start_time' => '09:00', 'end_time' => '09:30', 'sort_order' => 1],
            ['label' => '09:30 AM - 10:00 AM', 'start_time' => '09:30', 'end_time' => '10:00', 'sort_order' => 2],
            ['label' => '10:00 AM - 10:30 AM', 'start_time' => '10:00', 'end_time' => '10:30', 'sort_order' => 3],
            ['label' => '10:30 AM - 11:00 AM', 'start_time' => '10:30', 'end_time' => '11:00', 'sort_order' => 4],
            ['label' => '06:00 PM - 06:30 PM', 'start_time' => '18:00', 'end_time' => '18:30', 'sort_order' => 5],
            ['label' => '06:30 PM - 07:00 PM', 'start_time' => '18:30', 'end_time' => '19:00', 'sort_order' => 6],
        ];

        foreach ($slots as $slot) {
            DoctorConsultationSlot::updateOrCreate(
                [
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                ],
                [
                    'label' => $slot['label'],
                    'sort_order' => $slot['sort_order'],
                    'status' => true,
                ]
            );
        }

        $doctorData = [
            // Cardiology
            [
                'name' => 'Dr. Rahat Karim',
                'email' => 'dr.rahat.karim@example.com',
                'phone' => '01711100001',
                'address' => 'Dhanmondi, Dhaka',
                'department' => 'Cardiology',
                'specialty' => 'Interventional Cardiology',
                'designation' => 'Senior Consultant',
                'qualification' => 'MBBS, FCPS (Cardiology)',
                'experience_years' => 14,
                'consultation_fee' => 1800,
                'video_consultation_fee' => 1400,
                'commission' => 10,
                'video_consultation_available' => true,
                'bio' => 'Experienced cardiologist focused on preventive and interventional care.',
            ],
            [
                'name' => 'Dr. Nabila Sattar',
                'email' => 'dr.nabila.sattar@example.com',
                'phone' => '01711100006',
                'address' => 'Dhanmondi, Dhaka',
                'department' => 'Cardiology',
                'specialty' => 'Interventional Cardiology',
                'designation' => 'Consultant',
                'qualification' => 'MBBS, MD (Cardiology)',
                'experience_years' => 9,
                'consultation_fee' => 1700,
                'video_consultation_fee' => 1300,
                'commission' => 9,
                'video_consultation_available' => true,
                'bio' => 'Cardiology consultant focusing on hypertension and ischemic heart disease.',
            ],
            [
                'name' => 'Dr. Farhan Kabir',
                'email' => 'dr.farhan.kabir@example.com',
                'phone' => '01711100007',
                'address' => 'Gulshan, Dhaka',
                'department' => 'Cardiology',
                'specialty' => 'Interventional Cardiology',
                'designation' => 'Associate Consultant',
                'qualification' => 'MBBS, FCPS (Medicine), Training in Cardiology',
                'experience_years' => 8,
                'consultation_fee' => 1500,
                'commission' => 8,
                'video_consultation_available' => false,
                'bio' => 'Provides evidence-based management for chronic cardiac patients.',
            ],

            // Medicine
            [
                'name' => 'Dr. Saima Nusrat',
                'email' => 'dr.saima.nusrat@example.com',
                'phone' => '01711100002',
                'address' => 'Banani, Dhaka',
                'department' => 'Medicine',
                'specialty' => 'Clinical Nutrition',
                'designation' => 'Consultant Physician',
                'qualification' => 'MBBS, MD (Internal Medicine)',
                'experience_years' => 10,
                'consultation_fee' => 1400,
                'video_consultation_fee' => 1100,
                'commission' => 8,
                'video_consultation_available' => true,
                'bio' => 'Internal medicine consultant with integrated nutrition-centered treatment plans.',
            ],
            [
                'name' => 'Dr. Samiul Bari',
                'email' => 'dr.samiul.bari@example.com',
                'phone' => '01711100008',
                'address' => 'Uttara, Dhaka',
                'department' => 'Medicine',
                'specialty' => 'Clinical Nutrition',
                'designation' => 'Consultant',
                'qualification' => 'MBBS, FCPS (Medicine)',
                'experience_years' => 11,
                'consultation_fee' => 1450,
                'video_consultation_fee' => 1200,
                'commission' => 8.5,
                'video_consultation_available' => true,
                'bio' => 'Treats diabetes, thyroid and metabolic disorders with lifestyle support.',
            ],
            [
                'name' => 'Dr. Afroza Rahman',
                'email' => 'dr.afroza.rahman@example.com',
                'phone' => '01711100009',
                'address' => 'Mirpur, Dhaka',
                'department' => 'Medicine',
                'specialty' => 'Clinical Nutrition',
                'designation' => 'Associate Consultant',
                'qualification' => 'MBBS, MD (Medicine)',
                'experience_years' => 7,
                'consultation_fee' => 1350,
                'video_consultation_fee' => 1000,
                'commission' => 7.5,
                'video_consultation_available' => true,
                'bio' => 'Focuses on preventive medicine and long-term chronic care follow-up.',
            ],

            // Neurology
            [
                'name' => 'Dr. Tanjim Hasan',
                'email' => 'dr.tanjim.hasan@example.com',
                'phone' => '01711100003',
                'address' => 'Uttara, Dhaka',
                'department' => 'Neurology',
                'specialty' => 'Neurology',
                'designation' => 'Associate Consultant',
                'qualification' => 'MBBS, FCPS (Neurology)',
                'experience_years' => 9,
                'consultation_fee' => 1600,
                'commission' => 9,
                'video_consultation_available' => false,
                'bio' => 'Neurology specialist managing headache, stroke follow-up, and nerve disorders.',
            ],
            [
                'name' => 'Dr. Imran Hossain',
                'email' => 'dr.imran.hossain@example.com',
                'phone' => '01711100010',
                'address' => 'Banani, Dhaka',
                'department' => 'Neurology',
                'specialty' => 'Neurology',
                'designation' => 'Senior Consultant',
                'qualification' => 'MBBS, MD (Neurology)',
                'experience_years' => 13,
                'consultation_fee' => 1750,
                'video_consultation_fee' => 1450,
                'commission' => 10,
                'video_consultation_available' => true,
                'bio' => 'Handles epilepsy, migraine and neuropathy with structured care plans.',
            ],
            [
                'name' => 'Dr. Lubna Ahmed',
                'email' => 'dr.lubna.ahmed@example.com',
                'phone' => '01711100011',
                'address' => 'Dhanmondi, Dhaka',
                'department' => 'Neurology',
                'specialty' => 'Neurology',
                'designation' => 'Consultant',
                'qualification' => 'MBBS, FCPS (Neurology)',
                'experience_years' => 8,
                'consultation_fee' => 1550,
                'video_consultation_fee' => 1250,
                'commission' => 8,
                'video_consultation_available' => true,
                'bio' => 'Special interest in dizziness, movement disorders and sleep-related issues.',
            ],

            // Pulmonology
            [
                'name' => 'Dr. Sharmeen Akter',
                'email' => 'dr.sharmeen.akter@example.com',
                'phone' => '01711100004',
                'address' => 'Mirpur, Dhaka',
                'department' => 'Pulmonology',
                'specialty' => 'Pulmonology',
                'designation' => 'Consultant',
                'qualification' => 'MBBS, MD (Chest Diseases)',
                'experience_years' => 11,
                'consultation_fee' => 1500,
                'video_consultation_fee' => 1150,
                'commission' => 7.5,
                'video_consultation_available' => true,
                'bio' => 'Pulmonologist handling asthma, COPD and respiratory infection pathways.',
            ],
            [
                'name' => 'Dr. Rezaul Karim',
                'email' => 'dr.rezaul.karim@example.com',
                'phone' => '01711100012',
                'address' => 'Uttara, Dhaka',
                'department' => 'Pulmonology',
                'specialty' => 'Pulmonology',
                'designation' => 'Senior Consultant',
                'qualification' => 'MBBS, FCPS (Pulmonology)',
                'experience_years' => 15,
                'consultation_fee' => 1700,
                'video_consultation_fee' => 1350,
                'commission' => 9.5,
                'video_consultation_available' => true,
                'bio' => 'Experienced in chronic lung disease and post-infection respiratory rehab.',
            ],
            [
                'name' => 'Dr. Tania Noor',
                'email' => 'dr.tania.noor@example.com',
                'phone' => '01711100013',
                'address' => 'Bashundhara, Dhaka',
                'department' => 'Pulmonology',
                'specialty' => 'Pulmonology',
                'designation' => 'Associate Consultant',
                'qualification' => 'MBBS, MD (Respiratory Medicine)',
                'experience_years' => 7,
                'consultation_fee' => 1450,
                'commission' => 7,
                'video_consultation_available' => false,
                'bio' => 'Treats allergy-related breathing disorders and lifestyle-linked lung issues.',
            ],

            // Acupuncture
            [
                'name' => 'Dr. Mahfuz Alam',
                'email' => 'dr.mahfuz.alam@example.com',
                'phone' => '01711100005',
                'address' => 'Gulshan, Dhaka',
                'department' => 'Acupuncture',
                'specialty' => 'Acupuncture Therapy',
                'designation' => 'Consultant Acupuncturist',
                'qualification' => 'BAMS, Diploma in Acupuncture',
                'experience_years' => 12,
                'consultation_fee' => 1300,
                'commission' => 8,
                'video_consultation_available' => false,
                'bio' => 'Acupuncture specialist providing pain and stress management support.',
            ],
            [
                'name' => 'Dr. Nusrat Jahan',
                'email' => 'dr.nusrat.jahan@example.com',
                'phone' => '01711100014',
                'address' => 'Banani, Dhaka',
                'department' => 'Acupuncture',
                'specialty' => 'Acupuncture Therapy',
                'designation' => 'Consultant',
                'qualification' => 'MBBS, Certified Acupuncture Practitioner',
                'experience_years' => 9,
                'consultation_fee' => 1250,
                'video_consultation_fee' => 980,
                'commission' => 7.5,
                'video_consultation_available' => true,
                'bio' => 'Works on chronic pain, migraine, and stress-related musculoskeletal issues.',
            ],
            [
                'name' => 'Dr. Arif Chowdhury',
                'email' => 'dr.arif.chowdhury@example.com',
                'phone' => '01711100015',
                'address' => 'Mohakhali, Dhaka',
                'department' => 'Acupuncture',
                'specialty' => 'Acupuncture Therapy',
                'designation' => 'Associate Consultant',
                'qualification' => 'BAMS, Fellowship in Integrative Medicine',
                'experience_years' => 8,
                'consultation_fee' => 1200,
                'commission' => 7,
                'video_consultation_available' => false,
                'bio' => 'Integrative therapy approach for joint pain, insomnia and anxiety support.',
            ],
        ];

        foreach ($doctorData as $item) {
            $department = DoctorDepartment::where('name', $item['department'])->first();
            $specialty = DoctorSpecialty::where('name', $item['specialty'])->first();

            $doctor = Doctor::withTrashed()->where('email', $item['email'])->first();
            if ($doctor && $doctor->trashed()) {
                $doctor->restore();
            }

            Doctor::updateOrCreate(
                ['email' => $item['email']],
                [
                    'code' => $doctor?->code ?: doctor_code(),
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'phone' => $item['phone'],
                    'address' => $item['address'],
                    'doctor_department_id' => $department?->id,
                    'doctor_specialty_id' => $specialty?->id,
                    'designation' => $item['designation'],
                    'qualification' => $item['qualification'],
                    'experience_years' => $item['experience_years'],
                    'bio' => $item['bio'],
                    'consultation_fee' => $item['consultation_fee'],
                    'video_consultation_fee' => $item['video_consultation_available']
                        ? ($item['video_consultation_fee'] ?? $item['consultation_fee'])
                        : null,
                    'commission' => $item['commission'],
                    'video_consultation_available' => $item['video_consultation_available'],
                    'status' => true,
                ]
            );
        }
    }
}
