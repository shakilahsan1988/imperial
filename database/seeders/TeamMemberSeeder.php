<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Md Mahbubor Rahman',
                'slug' => 'md-mahbubor-rahman',
                'designation' => 'Chief Executive Officer',
                'image' => 'uploads/management/Md Mahbubor Rahman - MD and CEO.jpg',
                'bio' => 'Leading Imperial Health with a vision to transform healthcare in Bangladesh through innovation, compassion, and excellence.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Mehedi Hasan Chowdhury',
                'slug' => 'mehedi-hasan-chowdhury',
                'designation' => 'General Manager',
                'image' => 'uploads/management/Mehedi Hasan Chowdhury - General Manager.jpg',
                'bio' => 'Driving operational excellence and ensuring seamless coordination across all departments to deliver exceptional patient care.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Md Arif Hasan',
                'slug' => 'md-arif-hasan',
                'designation' => 'Deputy General Manager',
                'image' => 'uploads/management/Md Arif Hasan - Deputy General Manager.jpg',
                'bio' => 'Supporting strategic initiatives and managing day-to-day operations to maintain the highest standards of healthcare service.',
                'sort_order' => 3,
                'status' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['slug' => $member['slug']],
                $member
            );
        }
    }
}
