<?php

namespace App\Modules\Organization\app\Http\Request\Employee;




use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'required|unique:admins,phone',
            'email' => 'nullable|unique:admins,email',
            'password' => 'required|string|min:6',
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
