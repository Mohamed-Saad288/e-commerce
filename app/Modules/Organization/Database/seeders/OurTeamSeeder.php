<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\OurTeam\OurTeam;
use Illuminate\Database\Seeder;

class OurTeamSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $teamMembers = [
            [
                'name' => 'John Anderson - CEO',
                'facebook_link' => 'https://facebook.com/johnanderson',
                'x_link' => 'https://twitter.com/johnanderson',
                'instagram_link' => 'https://instagram.com/johnanderson',
                'tiktok_link' => 'https://tiktok.com/@johnanderson',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'name' => 'Sarah Mitchell - CTO',
                'facebook_link' => 'https://facebook.com/sarahmitchell',
                'x_link' => 'https://twitter.com/sarahmitchell',
                'instagram_link' => 'https://instagram.com/sarahmitchell',
                'tiktok_link' => 'https://tiktok.com/@sarahmitchell',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'name' => 'Michael Chen - Head of Sales',
                'facebook_link' => 'https://facebook.com/michaelchen',
                'x_link' => 'https://twitter.com/michaelchen',
                'instagram_link' => 'https://instagram.com/michaelchen',
                'tiktok_link' => 'https://tiktok.com/@michaelchen',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'name' => 'Emily Rodriguez - Customer Success Manager',
                'facebook_link' => 'https://facebook.com/emilyrodriguez',
                'x_link' => 'https://twitter.com/emilyrodriguez',
                'instagram_link' => 'https://instagram.com/emilyrodriguez',
                'tiktok_link' => 'https://tiktok.com/@emilyrodriguez',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'name' => 'David Thompson - Marketing Director',
                'facebook_link' => 'https://facebook.com/davidthompson',
                'x_link' => 'https://twitter.com/davidthompson',
                'instagram_link' => 'https://instagram.com/davidthompson',
                'tiktok_link' => 'https://tiktok.com/@davidthompson',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'name' => 'Lisa Wang - Operations Manager',
                'facebook_link' => 'https://facebook.com/lisawang',
                'x_link' => 'https://twitter.com/lisawang',
                'instagram_link' => 'https://instagram.com/lisawang',
                'tiktok_link' => 'https://tiktok.com/@lisawang',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
        ];

        foreach ($teamMembers as $memberData) {
            OurTeam::create($memberData);
        }
    }
}
