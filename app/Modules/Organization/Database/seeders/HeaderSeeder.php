<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Header\Header;
use Illuminate\Database\Seeder;

class HeaderSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        Header::create([
            'en' => [
                'name' => 'Welcome to Our Store - Discover Amazing Products',
                'description' => 'Shop the latest electronics, fashion, and home goods at unbeatable prices. Enjoy free shipping on orders over $50 and experience exceptional customer service. Your satisfaction is our priority!',
            ],
            'ar' => [
                'name' => 'مرحبا بكم في متجرنا - اكتشف منتجات مذهلة',
                'description' => 'تسوق أحدث الإلكترونيات والأزياء والسلع المنزلية بأسعار لا تقبل المنافسة. استمتع بالشحن المجاني للطلبات التي تزيد عن 50 دولارًا واختبر خدمة عملاء استثنائية. رضاك هو أولويتنا!',
            ],
            'organization_id' => $organizationId,
            'employee_id' => $employeeId,
        ]);
    }
}
