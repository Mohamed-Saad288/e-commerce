<?php

namespace Database\Seeders;

use App\Modules\Organization\app\Models\City\City;
use App\Modules\Organization\app\Models\Country\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cities')->truncate();
        DB::table('cities_translations')->truncate();

        $country = Country::first();

        if ($country) {
            // Saudi Arabia cities
            $cities = [
                ['en' => 'Riyadh', 'ar' => 'الرياض'],
                ['en' => 'Jeddah', 'ar' => 'جدة'],
                ['en' => 'Mecca', 'ar' => 'مكة المكرمة'],
                ['en' => 'Medina', 'ar' => 'المدينة المنورة'],
                ['en' => 'Dammam', 'ar' => 'الدمام'],
                ['en' => 'Khobar', 'ar' => 'الخبر'],
                ['en' => 'Taif', 'ar' => 'الطائف'],
                ['en' => 'Abha', 'ar' => 'أبها'],
            ];

            foreach ($cities as $cityData) {
                City::create([
                    'country_id' => $country->id,
                    'is_active' => true,
                    'en' => [
                        'name' => $cityData['en'],
                    ],
                    'ar' => [
                        'name' => $cityData['ar'],
                    ],
                ]);
            }
        }
    }
}
