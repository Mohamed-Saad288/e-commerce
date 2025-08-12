<?php

namespace App\Modules\Admin\app\Http\Request\Orgnization;




use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
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
            'address' => 'nullable',
            'website_link' => 'required|max:255',
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
