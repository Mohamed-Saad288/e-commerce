<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Term\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $terms = [
            [
                'en' => [
                    'description' => 'Terms and Conditions: By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to these terms, please do not use this website. We reserve the right to modify these terms at any time.',
                ],
                'ar' => [
                    'description' => 'الشروط والأحكام: من خلال الوصول إلى هذا الموقع واستخدامه، فإنك تقبل وتوافق على الالتزام بشروط وأحكام هذه الاتفاقية. إذا كنت لا توافق على هذه الشروط، يرجى عدم استخدام هذا الموقع. نحتفظ بالحق في تعديل هذه الشروط في أي وقت.',
                ],
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'en' => [
                    'description' => 'Privacy Policy: We are committed to protecting your privacy. We collect and use your personal information only for providing and improving our services. We will not share your information with third parties without your consent. Your data is encrypted and stored securely.',
                ],
                'ar' => [
                    'description' => 'سياسة الخصوصية: نحن ملتزمون بحماية خصوصيتك. نحن نجمع ونستخدم معلوماتك الشخصية فقط لتوفير وتحسين خدماتنا. لن نشارك معلوماتك مع أطراف ثالثة دون موافقتك. يتم تشفير بياناتك وتخزينها بشكل آمن.',
                ],
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'en' => [
                    'description' => 'Shipping Policy: We process orders within 1-2 business days. Shipping times vary by location. Standard shipping takes 3-5 business days, while express shipping takes 1-2 business days. International orders may take longer. Tracking information will be provided via email.',
                ],
                'ar' => [
                    'description' => 'سياسة الشحن: نقوم بمعالجة الطلبات خلال 1-2 يوم عمل. تختلف أوقات الشحن حسب الموقع. يستغرق الشحن القياسي 3-5 أيام عمل، بينما يستغرق الشحن السريع 1-2 يوم عمل. قد تستغرق الطلبات الدولية وقتًا أطول. سيتم توفير معلومات التتبع عبر البريد الإلكتروني.',
                ],
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'en' => [
                    'description' => 'Return and Refund Policy: We offer a 30-day return policy on most items. Products must be returned in their original condition and packaging. Refunds will be processed within 5-7 business days after we receive the returned item. Original shipping costs are non-refundable.',
                ],
                'ar' => [
                    'description' => 'سياسة الإرجاع والاسترداد: نقدم سياسة إرجاع لمدة 30 يومًا على معظم العناصر. يجب إرجاع المنتجات في حالتها الأصلية وتغليفها. سيتم معالجة المبالغ المستردة خلال 5-7 أيام عمل بعد استلام العنصر المرتجع. تكاليف الشحن الأصلية غير قابلة للاسترداد.',
                ],
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'en' => [
                    'description' => 'Payment Terms: We accept major credit cards, PayPal, and bank transfers. All payments are processed securely through encrypted connections. Prices are listed in USD and include applicable taxes. Payment must be received before order processing.',
                ],
                'ar' => [
                    'description' => 'شروط الدفع: نقبل بطاقات الائتمان الرئيسية وPayPal والتحويلات البنكية. يتم معالجة جميع المدفوعات بشكل آمن من خلال اتصالات مشفرة. الأسعار مدرجة بالدولار الأمريكي وتشمل الضرائب المطبقة. يجب استلام الدفع قبل معالجة الطلب.',
                ],
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
            [
                'en' => [
                    'description' => 'Warranty Information: All products come with a manufacturer warranty. Electronics typically have 1-2 years warranty coverage. For warranty claims, please contact our customer support with your order number and proof of purchase.',
                ],
                'ar' => [
                    'description' => 'معلومات الضمان: جميع المنتجات تأتي مع ضمان الشركة المصنعة. عادة ما تحتوي الإلكترونيات على تغطية ضمان لمدة 1-2 سنة. لمطالبات الضمان، يرجى الاتصال بدعم العملاء برقم طلبك وإثبات الشراء.',
                ],
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
            ],
        ];

        foreach ($terms as $termData) {
            Term::create($termData);
        }
    }
}
