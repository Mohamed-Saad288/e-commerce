<?php

namespace App\Modules\Admin\Database\seeders;

use App\Modules\Admin\app\Models\Admin\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{

    public function run()
    {
        Admin::query()->create([
            'name' => 'Admin',
            "phone" => "01029869611",
            'email' => 'admin@example',
            'password' => "password",
        ]);
    }
}
