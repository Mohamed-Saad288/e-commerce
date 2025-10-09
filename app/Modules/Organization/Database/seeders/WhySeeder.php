<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Why\Why;
use Illuminate\Database\Seeder;

class WhySeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $whys = [
            [
                'en' => [
                    'name' => 'Free Shipping',
                    'description' => 'Enjoy free shipping on all orders over $50. Fast and reliable delivery to your doorstep.',
                ],
                'ar' => [
                    'name' => 'شحن مجاني',
                    'description' => 'استمتع بالشحن المجاني على جميع الطلبات التي تزيد عن 50 دولارًا. توصيل سريع وموثوق إلى باب منزلك.',
                ],
                'sort_order' => 1,
            ],
            [
                'en' => [
                    'name' => 'Secure Payment',
                    'description' => '100% secure payment processing with SSL encryption. Your financial information is always protected.',
                ],
                'ar' => [
                    'name' => 'دفع آمن',
                    'description' => 'معالجة دفع آمنة بنسبة 100٪ مع تشفير SSL. معلوماتك المالية محمية دائمًا.',
                ],
                'sort_order' => 2,
            ],
            [
                'en' => [
                    'name' => '24/7 Support',
                    'description' => 'Our customer support team is available around the clock to assist you with any questions or concerns.',
                ],
                'ar' => [
                    'name' => 'دعم 24/7',
                    'description' => 'فريق دعم العملاء لدينا متاح على مدار الساعة لمساعدتك في أي أسئلة أو مخاوف.',
                ],
                'sort_order' => 3,
            ],
            [
                'en' => [
                    'name' => 'Easy Returns',
                    'description' => 'Hassle-free returns within 30 days. No questions asked, full refund guaranteed.',
                ],
                'ar' => [
                    'name' => 'إرجاع سهل',
                    'description' => 'إرجاع بدون متاعب خلال 30 يومًا. بدون أسئلة، استرداد كامل مضمون.',
                ],
                'sort_order' => 4,
            ],
            [
                'en' => [
                    'name' => 'Quality Guarantee',
                    'description' => 'All products are carefully selected and tested to ensure the highest quality standards.',
                ],
                'ar' => [
                    'name' => 'ضمان الجودة',
                    'description' => 'يتم اختبار جميع المنتجات بعناية لضمان أعلى معايير الجودة.',
                ],
                'sort_order' => 5,
            ],
            [
                'en' => [
                    'name' => 'Best Prices',
                    'description' => 'Competitive pricing with regular discounts and special offers. Get the best value for your money.',
                ],
                'ar' => [
                    'name' => 'أفضل الأسعار',
                    'description' => 'أسعار تنافسية مع خصومات منتظمة وعروض خاصة. احصل على أفضل قيمة لأموالك.',
                ],
                'sort_order' => 6,
            ],
        ];

        foreach ($whys as $whyData) {
            $whyData['organization_id'] = $organizationId;
            $whyData['employee_id'] = $employeeId;
            Why::create($whyData);
        }
    }
}
