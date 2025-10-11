<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Privacy\Privacy;
use Illuminate\Database\Seeder;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        Privacy::create([
            'en' => [
                'description' => 'Your privacy is important to us. This privacy policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services. We collect personal information that you provide to us such as name, address, contact information, passwords and security data, and payment information. We use this information to facilitate account creation and authentication, send administrative information, fulfill and manage purchases and orders, deliver targeted advertising, request feedback and contact you, enable user-to-user communications, manage user accounts, protect our services, enforce our terms and policies, and respond to legal requests. We may share your information with third-party vendors, service providers, contractors or agents who perform services for us or on our behalf. We will retain your information only for as long as necessary to fulfill the purposes outlined in this privacy policy unless a longer retention period is required or permitted by law. We use administrative, technical, and physical security measures to help protect your personal information.',
            ],
            'ar' => [
                'description' => 'خصوصيتك مهمة بالنسبة لنا. توضح سياسة الخصوصية هذه كيفية جمع معلوماتك واستخدامها والكشف عنها وحمايتها عند زيارة موقعنا واستخدام خدماتنا. نجمع المعلومات الشخصية التي تقدمها لنا مثل الاسم والعنوان ومعلومات الاتصال وكلمات المرور وبيانات الأمان ومعلومات الدفع. نستخدم هذه المعلومات لتسهيل إنشاء الحساب والمصادقة، وإرسال معلومات إدارية، وتنفيذ وإدارة المشتريات والطلبات، وتقديم إعلانات مستهدفة، وطلب التعليقات والاتصال بك، وتمكين الاتصالات بين المستخدمين، وإدارة حسابات المستخدمين، وحماية خدماتنا، وفرض شروطنا وسياساتنا، والرد على الطلبات القانونية. قد نشارك معلوماتك مع بائعين خارجيين أو مزودي خدمات أو مقاولين أو وكلاء يقدمون خدمات لنا أو نيابة عنا. سنحتفظ بمعلوماتك فقط طالما كان ذلك ضروريًا لتحقيق الأغراض الموضحة في سياسة الخصوصية هذه ما لم تكن هناك حاجة إلى فترة احتفاظ أطول أو يسمح بها القانون. نستخدم تدابير أمنية إدارية وتقنية ومادية للمساعدة في حماية معلوماتك الشخصية.',
            ],
            'organization_id' => $organizationId,
            'employee_id' => $employeeId,
        ]);
    }
}

