<?php

namespace App\Modules\Organization\app\Http\Request\OurTeam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOurTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable',
            'facebook_link' => 'nullable|max:255',
            'x_link' => 'nullable|max:255',
            'instagram_link' => 'nullable|max:255',
            'tiktok_link' => 'nullable|max:255',
        ];
    }
}
