<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Option\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $options = [
            [
                'en' => ['name' => 'Color'],
                'ar' => ['name' => 'اللون'],

            ],
            [
                'en' => ['name' => 'Size'],
                'ar' => ['name' => 'الحجم'],
            ],
            [
                'en' => ['name' => 'Storage'],
                'ar' => ['name' => 'السعة التخزينية'],
            ],
            [
                'en' => ['name' => 'Material'],
                'ar' => ['name' => 'المادة'],
            ],
            [
                'en' => ['name' => 'RAM'],
                'ar' => ['name' => 'الذاكرة العشوائية'],
            ],
        ];

        foreach ($options as $optionData) {
            $optionData['organization_id'] = $organizationId;
            $optionData['employee_id'] = $employeeId;
            Option::create($optionData);
        }
    }
}
