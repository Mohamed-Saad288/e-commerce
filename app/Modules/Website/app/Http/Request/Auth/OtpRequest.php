<?php

namespace App\Modules\Website\app\Http\Request\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
    public function rules(): array
    {
        $data = [
            "email" => "required|email|exists:users,email",
        ];

        if ($this->route()->getName() == "api.v1.check_otp") {
            $data["code"] = "required|exists:users,code";
        }
        return $data;
    }
}
