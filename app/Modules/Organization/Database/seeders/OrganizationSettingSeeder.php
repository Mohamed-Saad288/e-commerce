<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\OrganizationSetting\OrganizationSetting;
use Illuminate\Database\Seeder;

class OrganizationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        OrganizationSetting::updateOrCreate([
            'organization_id' => $organizationId,
        ], [
            'employee_id' => $employeeId,
            'logo' => 'logo.png',
            'primary_color' => '#0d6efd',
            'secondary_color' => '#6c757d',
            'facebook_link' => 'https://facebook.com/example',
            'instagram_link' => 'https://instagram.com/example',
            'phone' => '+1234567890',
            'email' => 'info@example.com',
            'address' => '123 Main St, City',
            'lat' => '0.000000',
            'lng' => '0.000000',
            'x_link' => 'https://x.com/example',
            'tiktok_link' => 'https://tiktok.com/@example',
        ]);
    }
}
