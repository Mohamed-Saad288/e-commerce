<?php

namespace App\Modules\Website\app\Http\Request\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $countryId = $this->input('country_id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'lang' => ['nullable', 'string'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'city_id' => [
                'nullable',
                Rule::exists('cities', 'id')->where(function ($query) use ($countryId) {
                    $query->where('country_id', $countryId);
                }),
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('auth.name_required'),
            'name.max' => __('auth.name_max'),
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.email_invalid'),
            'email.unique' => __('auth.email_unique'),
            'phone.max' => __('auth.phone_max'),
            'password.required' => __('auth.password_required'),
            'password.min' => __('auth.password_min'),
            'password.confirmed' => __('auth.password_confirmed'),
            'country_id.exists' => __('auth.country_invalid'),
            'city_id.exists' => __('auth.city_invalid'),

        ];
    }
}
