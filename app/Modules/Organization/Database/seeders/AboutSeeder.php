<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\About\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $abouts = [
            [
                'en' => [
                    'name' => 'Our Story',
                    'description' => 'Founded in 2020, we started with a simple mission: to make quality products accessible to everyone. What began as a small online store has grown into a trusted marketplace serving thousands of customers worldwide. We believe in innovation, customer satisfaction, and building lasting relationships.',
                ],
                'ar' => [
                    'name' => 'قصتنا',
                    'description' => 'تأسست في عام 2020، بدأنا بمهمة بسيطة: جعل المنتجات عالية الجودة متاحة للجميع. ما بدأ كمتجر صغير عبر الإنترنت نما ليصبح سوقًا موثوقًا يخدم الآلاف من العملاء في جميع أنحاء العالم. نؤمن بالابتكار ورضا العملاء وبناء علاقات دائمة.',
                ],
                'sort_order' => 1,
            ],
            [
                'en' => [
                    'name' => 'Our Mission',
                    'description' => 'To provide the best online shopping experience through quality products, competitive prices, and exceptional customer service. We are committed to sustainability and ethical business practices.',
                ],
                'ar' => [
                    'name' => 'مهمتنا',
                    'description' => 'توفير أفضل تجربة تسوق عبر الإنترنت من خلال المنتجات عالية الجودة والأسعار التنافسية وخدمة العملاء الاستثنائية. نحن ملتزمون بالاستدامة والممارسات التجارية الأخلاقية.',
                ],
                'sort_order' => 2,
            ],
            [
                'en' => [
                    'name' => 'Our Values',
                    'description' => 'Integrity, Quality, Innovation, and Customer Focus. These core values guide every decision we make and every interaction we have with our customers.',
                ],
                'ar' => [
                    'name' => 'قيمنا',
                    'description' => 'النزاهة والجودة والابتكار والتركيز على العملاء. هذه القيم الأساسية توجه كل قرار نتخذه وكل تفاعل لدينا مع عملائنا.',
                ],
                'sort_order' => 3,
            ],
        ];

        foreach ($abouts as $aboutData) {
            $aboutData['organization_id'] = $organizationId;
            $aboutData['employee_id'] = $employeeId;
            About::create($aboutData);
        }
    }
}
