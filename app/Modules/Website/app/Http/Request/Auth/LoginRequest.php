<?php

namespace App\Modules\Website\app\Http\Request\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.email_invalid'),
            'email.exists' => __('auth.email_not_found'),
            'password.required' => __('auth.password_required'),
            'password.min' => __('auth.password_min'),
        ];
    }
}
