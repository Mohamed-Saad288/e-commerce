<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Question\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $questions = [
            [
                'en' => [
                    'question' => 'What are your shipping options?',
                    'answer' => 'We offer standard shipping (3-5 business days), express shipping (1-2 business days), and same-day delivery in select areas.',
                ],
                'ar' => [
                    'question' => 'ما هي خيارات الشحن لديكم؟',
                    'answer' => 'نقدم الشحن القياسي (3-5 أيام عمل)، والشحن السريع (1-2 يوم عمل)، والتوصيل في نفس اليوم في مناطق مختارة.',
                ],
                'sort_order' => 1,
            ],
            [
                'en' => [
                    'question' => 'What is your return policy?',
                    'answer' => 'We accept returns within 30 days of purchase. Items must be unused and in original packaging. Refunds are processed within 5-7 business days.',
                ],
                'ar' => [
                    'question' => 'ما هي سياسة الإرجاع الخاصة بكم؟',
                    'answer' => 'نقبل المرتجعات خلال 30 يومًا من الشراء. يجب أن تكون العناصر غير مستخدمة وفي العبوة الأصلية. يتم معالجة المبالغ المستردة خلال 5-7 أيام عمل.',
                ],
                'sort_order' => 2,
            ],
            [
                'en' => [
                    'question' => 'Do you ship internationally?',
                    'answer' => 'Yes, we ship to over 100 countries worldwide. International shipping rates and delivery times vary by destination.',
                ],
                'ar' => [
                    'question' => 'هل تشحنون دوليًا؟',
                    'answer' => 'نعم، نشحن إلى أكثر من 100 دولة حول العالم. تختلف أسعار الشحن الدولي وأوقات التسليم حسب الوجهة.',
                ],
                'sort_order' => 3,
            ],
            [
                'en' => [
                    'question' => 'How can I track my order?',
                    'answer' => 'Once your order ships, you will receive a tracking number via email. You can use this number to track your package on our website or the carrier\'s website.',
                ],
                'ar' => [
                    'question' => 'كيف يمكنني تتبع طلبي؟',
                    'answer' => 'بمجرد شحن طلبك، ستتلقى رقم تتبع عبر البريد الإلكتروني. يمكنك استخدام هذا الرقم لتتبع طردك على موقعنا أو موقع شركة الشحن.',
                ],
                'sort_order' => 4,
            ],
            [
                'en' => [
                    'question' => 'What payment methods do you accept?',
                    'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, Apple Pay, and bank transfers.',
                ],
                'ar' => [
                    'question' => 'ما هي طرق الدفع التي تقبلونها؟',
                    'answer' => 'نقبل جميع بطاقات الائتمان الرئيسية (فيزا، ماستركارد، أمريكان إكسبريس)، وPayPal، وApple Pay، والتحويلات البنكية.',
                ],
                'sort_order' => 5,
            ],
            [
                'en' => [
                    'question' => 'Do you offer warranty on products?',
                    'answer' => 'Yes, all products come with a manufacturer\'s warranty. Electronics typically have 1-2 years warranty, while other products have varying warranty periods.',
                ],
                'ar' => [
                    'question' => 'هل تقدمون ضمانًا على المنتجات؟',
                    'answer' => 'نعم، جميع المنتجات تأتي مع ضمان الشركة المصنعة. عادة ما تكون الإلكترونيات بضمان 1-2 سنة، بينما المنتجات الأخرى لها فترات ضمان متفاوتة.',
                ],
                'sort_order' => 6,
            ],
            [
                'en' => [
                    'question' => 'Can I change or cancel my order?',
                    'answer' => 'Orders can be changed or cancelled within 1 hour of placement. After this time, the order enters processing and cannot be modified.',
                ],
                'ar' => [
                    'question' => 'هل يمكنني تغيير أو إلغاء طلبي؟',
                    'answer' => 'يمكن تغيير أو إلغاء الطلبات خلال ساعة واحدة من الطلب. بعد هذا الوقت، يدخل الطلب في المعالجة ولا يمكن تعديله.',
                ],
                'sort_order' => 7,
            ],
            [
                'en' => [
                    'question' => 'How do I contact customer support?',
                    'answer' => 'You can reach our customer support team via email, phone, or live chat. Our support hours are Monday-Friday 9AM-6PM.',
                ],
                'ar' => [
                    'question' => 'كيف أتواصل مع دعم العملاء؟',
                    'answer' => 'يمكنك التواصل مع فريق دعم العملاء عبر البريد الإلكتروني أو الهاتف أو الدردشة المباشرة. ساعات الدعم من الاثنين إلى الجمعة 9 صباحًا - 6 مساءً.',
                ],
                'sort_order' => 8,
            ],
        ];

        foreach ($questions as $questionData) {
            $questionData['organization_id'] = $organizationId;
            $questionData['employee_id'] = $employeeId;
            Question::create($questionData);
        }
    }
}
