<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Organization\app\Models\OrganizationPaymentMethod;
use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class OrganizationPaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = Organization::all();
        $paymentMethods = PaymentMethod::all();

        foreach ($organizations as $organization) {
            foreach ($paymentMethods as $paymentMethod) {
                OrganizationPaymentMethod::updateOrCreate(
                    [
                        'organization_id' => $organization->id,
                        'payment_method_id' => $paymentMethod->id,
                    ],
                    [
                        'is_active' => false,
                        'sort_order' => 0,
                        'credentials' => json_encode([]),
                    ]
                );
            }
        }
    }
}
