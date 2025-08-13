<?php

namespace App\Modules\Organization\app\Http\Request\Auth;

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
            'email' => ['required_without:phone', 'email', 'string'],
            'phone' => ['required_without:email', 'string'],
            'password' => ['required', 'string', 'max:255', 'min:6'],
        ];
    }
}
