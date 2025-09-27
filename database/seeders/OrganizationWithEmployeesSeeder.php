<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrganizationWithEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'Tech Solutions Inc.',
                'phone' => '+1234567890',
                'email' => 'contact@techsolutions.com',
                'address' => '123 Business Street, Tech City, TC 12345',
                'website_link' => 'https://www.techsolutions.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Creative Designs LLC',
                'phone' => '+1987654321',
                'email' => 'info@creativedesigns.com',
                'address' => '456 Creative Ave, Design City, DC 67890',
                'website_link' => 'https://www.creativedesigns.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($organizations as $orgData) {
            $organizationId = DB::table('organizations')->insertGetId($orgData);

            // Create employees for each organization
            $this->createEmployees($organizationId);
        }
    }

    private function createEmployees($organizationId): void
    {
        $employees = [
            [
                'name' => $organizationId === 1 ? 'John Master' : 'Alice Master',
                'phone' => $organizationId === 1 ? '+1234567891' : '+1987654322',
                'email' => $organizationId === 1 ? 'john@techsolutions.com' : 'alice@creativedesigns.com',
                'password' => Hash::make('password123'),
                'is_master' => true,
                'is_admin' => false,
                'organization_id' => $organizationId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => $organizationId === 1 ? 'Jane Admin' : 'Bob Admin',
                'phone' => $organizationId === 1 ? '+1234567892' : '+1987654323',
                'email' => $organizationId === 1 ? 'jane@techsolutions.com' : 'bob@creativedesigns.com',
                'password' => Hash::make('password123'),
                'is_master' => false,
                'is_admin' => true,
                'organization_id' => $organizationId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => $organizationId === 1 ? 'Mike Developer' : 'Carol Designer',
                'phone' => $organizationId === 1 ? '+1234567893' : '+1987654324',
                'email' => $organizationId === 1 ? 'mike@techsolutions.com' : 'carol@creativedesigns.com',
                'password' => Hash::make('password123'),
                'is_master' => false,
                'is_admin' => false,
                'organization_id' => $organizationId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('employees')->insert($employees);
    }

}
