<?php

namespace App\Modules\Organization\app\Http\Request\PaymentMethods;

use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class updateOrganizationPaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        // التحقق من أن المستخدم له منظمة وصلاحية تعديل طرق الدفع
        return auth()->check() && auth()->user()->organization;
    }

    public function rules(): array
    {
        $rules = [
            'is_active'   => 'nullable|boolean',
            'credentials' => 'nullable|array',
            'credentials.*' => 'nullable|string|max:255',
        ];

        if ($this->boolean('is_active')) {
            $paymentMethodId = $this->route('payment_method') ?? $this->route()->parameter('id');
            $paymentMethod = PaymentMethod::find($paymentMethodId);

            if ($paymentMethod) {
                $requiredSettings = is_array($paymentMethod->required_settings)
                    ? $paymentMethod->required_settings
                    : (json_decode($paymentMethod->required_settings, true) ?? []);

                foreach ($requiredSettings as $field) {
                    $rules["credentials.{$field}"] = 'required|string|min:1|max:255';
                }
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'is_active.boolean' => 'Payment method status must be true or false.',
            'credentials.array' => 'Credentials must be provided as an array.',
            'credentials.*.string' => 'Each credential field must be a string.',
            'credentials.*.max' => 'Each credential field must not exceed 255 characters.',
            'credentials.*.required' => 'This credential field is required when enabling the payment method.',
            'credentials.*.min' => 'This credential field must not be empty.',
        ];
    }

    public function attributes(): array
    {
        $attributes = [];

        if ($this->has('credentials') && is_array($this->input('credentials'))) {
            foreach ($this->input('credentials') as $key => $value) {
                $attributes["credentials.{$key}"] = ucfirst(str_replace('_', ' ', $key));
            }
        }

        return $attributes;
    }
}
