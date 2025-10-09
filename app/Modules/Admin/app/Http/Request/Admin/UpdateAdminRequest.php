<?php

namespace App\Modules\Admin\app\Http\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $adminId = $this->route('admin')->id ?? $this->route('admin');

        return [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|unique:admins,phone,'.$adminId,
            'email' => 'nullable|email|unique:admins,email,'.$adminId,
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
