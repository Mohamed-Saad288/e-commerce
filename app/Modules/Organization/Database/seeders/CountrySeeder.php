<?php

namespace Database\Seeders;

use App\Modules\Organization\app\Models\City\City;
use App\Modules\Organization\app\Models\Country\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = public_path('data/countries_cities.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        foreach ($data['countries'] as $countryData) {
            $country = new Country();

            foreach ($countryData['translations'] as $locale => $name) {
                $country->translateOrNew($locale)->name = $name;
            }

            $country->save();

            foreach ($countryData['cities'] as $cityData) {
                $city = new City();
                $city->country_id = $country->id;

                foreach ($cityData['translations'] as $locale => $name) {
                    $city->translateOrNew($locale)->name = $name;
                }

                $city->save();
            }
        }
    }
}

