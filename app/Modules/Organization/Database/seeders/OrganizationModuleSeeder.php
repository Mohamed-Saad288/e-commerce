<?php

namespace App\Modules\Organization\Database\seeders;

use Illuminate\Database\Seeder;

class OrganizationModuleSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Core structure first
            CategorySeeder::class,
            BrandSeeder::class,

            // Product options
            OptionSeeder::class,
            OptionItemSeeder::class,

            // Products (depends on categories, brands, and options)
            ProductSeeder::class,

            // Content pages
            HeaderSeeder::class,
            QuestionSeeder::class,
            AboutSeeder::class,
            WhySeeder::class,
            TermSeeder::class,
            OurTeamSeeder::class,
            //            OrganizationSettingSeeder::class,
        ]);
    }
}
