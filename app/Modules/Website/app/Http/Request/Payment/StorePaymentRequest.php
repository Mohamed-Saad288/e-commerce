<?php

namespace App\Modules\Website\app\Http\Request\Payment;

use App\Modules\Base\Enums\ActiveEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "order_id" => ["required" , Rule::exists("orders","id")->whereNull("deleted_at")
                ->where("user_id",auth()->user()->id)
            ],
            "payment_method_id" => ["required" , Rule::exists("payment_methods","id")->where("is_active",ActiveEnum::ACTIVE->value)],
            "receipt" => ["required" , 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
