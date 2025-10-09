<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Modules\Admin\Database\seeders\AdminSeeder;
use App\Modules\Organization\Database\seeders\OrganizationModuleSeeder;
use App\Modules\Organization\Database\seeders\OrganizationPaymentMethodSeeder;
use App\Modules\Organization\Database\seeders\PaymentMethodSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            OrganizationWithEmployeesSeeder::class,
            PaymentMethodSeeder::class,
            OrganizationPaymentMethodSeeder::class,
            OrganizationModuleSeeder::class,
            //            OptionsAndOptionItemsSeeder::class
        ]);
    }
}
