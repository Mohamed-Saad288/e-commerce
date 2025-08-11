<?php

namespace App\Modules\Admin\app\Http\Request\Orgnization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $organizationId = $this->route('organization')->id ?? $this->route('organization');
        return [
            'name'     => 'nullable|string|max:255',
            'phone'    => 'nullable|unique:organizations,phone,' . $organizationId,
            'email'    => 'nullable|email|unique:organizations,email,' . $organizationId,
            'address'  => 'nullable',
            'website_link' => 'nullable|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
