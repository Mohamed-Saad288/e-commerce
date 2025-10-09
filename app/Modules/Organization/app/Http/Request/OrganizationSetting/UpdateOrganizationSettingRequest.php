<?php

namespace App\Modules\Organization\app\Http\Request\OrganizationSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => ['nullable'],
            'primary_color' => ['nullable', 'string'],
            'secondary_color' => ['nullable', 'string'],
            'facebook_link' => ['nullable', 'string'],
            'instagram_link' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'lat' => ['nullable', 'string'],
            'lng' => ['nullable', 'string'],
            'x_link' => ['nullable', 'string'],
            'tiktok_link' => ['nullable', 'string'],
        ];
    }
}
