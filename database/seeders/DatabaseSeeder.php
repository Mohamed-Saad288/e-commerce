<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Modules\Admin\Database\seeders\AdminSeeder;
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
        // User::factory(10)->create();
        $this->call([
//            AdminSeeder::class,
        PaymentMethodSeeder::class,
            OrganizationPaymentMethodSeeder::class,
        ]);
    }
}
