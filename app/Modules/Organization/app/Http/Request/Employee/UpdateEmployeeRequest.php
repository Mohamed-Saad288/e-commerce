<?php

namespace App\Modules\Organization\app\Http\Request\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee')->id ?? $this->route('employee');
        return [
            'name'     => 'nullable|string|max:255',
            'phone'    => 'nullable|unique:admins,phone,' . $employeeId,
            'email'    => 'nullable|email|unique:admins,email,' . $employeeId,
            'is_master' => "nullable"
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
