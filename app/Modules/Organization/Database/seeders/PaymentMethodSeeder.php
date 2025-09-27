<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = [
            'stripe' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Stripe', 'description' => 'Pay securely with your credit or debit card using Stripe.'],
                    'ar' => ['name' => 'سترايب', 'description' => 'ادفع بأمان باستخدام بطاقة الائتمان أو الخصم عبر سترايب.'],
                ],
            ],
            'paypal' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'PayPal', 'description' => 'Pay easily with your PayPal account.'],
                    'ar' => ['name' => 'باي بال', 'description' => 'ادفع بسهولة باستخدام حساب باي بال الخاص بك.'],
                ],
            ],
            'cod' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Cash on Delivery', 'description' => 'Pay with cash upon delivery of your order.'],
                    'ar' => ['name' => 'الدفع عند الاستلام', 'description' => 'ادفع نقدًا عند استلام طلبك.'],
                ],
            ],
            'bank_transfer' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Bank Transfer', 'description' => 'Transfer the amount directly to our bank account.'],
                    'ar' => ['name' => 'التحويل البنكي', 'description' => 'قم بتحويل المبلغ مباشرة إلى حسابنا البنكي.'],
                ],
            ],
            'apple_pay' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Apple Pay', 'description' => 'Pay easily with Apple Pay on your iPhone or iPad.'],
                    'ar' => ['name' => 'آبل باي', 'description' => 'ادفع بسهولة باستخدام آبل باي على جهاز iPhone أو iPad.'],
                ],
            ],
            'google_pay' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Google Pay', 'description' => 'Quick checkout with Google Pay.'],
                    'ar' => ['name' => 'جوجل باي', 'description' => 'ادفع بسرعة باستخدام جوجل باي.'],
                ],
            ],
            'vodafone_cash' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Vodafone Cash', 'description' => 'Pay using Vodafone Cash mobile wallet.'],
                    'ar' => ['name' => 'فودافون كاش', 'description' => 'ادفع باستخدام محفظة فودافون كاش.'],
                ],
            ],
            'instapay' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Instapay', 'description' => 'Pay instantly using your Instapay account.'],
                    'ar' => ['name' => 'إنستا باي', 'description' => 'ادفع فورًا باستخدام حساب إنستا باي الخاص بك.'],
                ],
            ],
            'visa' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Visa', 'description' => 'Securely pay with your Visa card.'],
                    'ar' => ['name' => 'فيزا', 'description' => 'ادفع بأمان باستخدام بطاقة فيزا.'],
                ],
            ],
            'mastercard' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Mastercard', 'description' => 'Securely pay with your Mastercard.'],
                    'ar' => ['name' => 'ماستركارد', 'description' => 'ادفع بأمان باستخدام بطاقة ماستركارد.'],
                ],
            ],
            'mada' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Mada', 'description' => 'Use your Mada debit card for a secure payment.'],
                    'ar' => ['name' => 'مدى', 'description' => 'استخدم بطاقة مدى الخاصة بك للدفع الآمن.'],
                ],
            ],
            'fawry' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Fawry', 'description' => 'Pay through any Fawry payment channel.'],
                    'ar' => ['name' => 'فوري', 'description' => 'ادفع عبر أي من قنوات الدفع الخاصة بفوري.'],
                ],
            ],
            'tabby' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Tabby', 'description' => 'Buy now, pay later with Tabby.'],
                    'ar' => ['name' => 'تابي', 'description' => 'اشترِ الآن، وادفع لاحقًا مع تابي.'],
                ],
            ],
            'moyasar' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Moyasar', 'description' => 'Pay with a secure gateway for payments in Saudi Arabia.'],
                    'ar' => ['name' => 'ميسر', 'description' => 'ادفع باستخدام بوابة دفع آمنة للمدفوعات في المملكة العربية السعودية.'],
                ],
            ],
            'paymob' => [
                'is_active' => true,
                'translations' => [
                    'en' => ['name' => 'Paymob', 'description' => 'A payment gateway for online and in-store transactions.'],
                    'ar' => ['name' => 'باي موب', 'description' => 'بوابة دفع للمعاملات عبر الإنترنت وفي المتاجر.'],
                ],
            ],
        ];

        foreach ($paymentMethods as $code => $data) {
            $translations = $data['translations'];
            unset($data['translations']);

            $methodData = [
                'code' => $code,
                'icon' => 'icons/payments/' . $code . '.png',
                'is_active' => $data['is_active'],
                'required_settings' => json_encode(config("organization.payment_methods.$code.required_settings", [])),
            ];

            $paymentMethod = PaymentMethod::updateOrCreate(
                ['code' => $code],
                $methodData
            );

            foreach ($translations as $locale => $translation) {
                $paymentMethod->translateOrNew($locale)->name = $translation['name'];
                $paymentMethod->translateOrNew($locale)->description = $translation['description'];
            }

            $paymentMethod->save();
        }
    }
}
