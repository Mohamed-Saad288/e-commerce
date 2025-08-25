<?php

namespace App\Modules\Organization\app\Http\Request\OurTeam;

use App\Modules\Admin\Enums\Feature\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreOurTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'image' => "required",
            'facebook_link' => "nullable|max:255",
            'x_link' => "nullable|max:255",
            'instagram_link' => "nullable|max:255",
            'tiktok_link' => "nullable|max:255",
        ];
    }
}
