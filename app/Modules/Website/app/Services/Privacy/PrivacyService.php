<?php

namespace App\Modules\Website\app\Services\Privacy;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Privacy\Privacy;
use App\Modules\Website\app\Http\Resources\Privacy\PrivacyResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class PrivacyService
{
    public function fetchPrivacy(): DataSuccess
    {
        $privacy = Privacy::query()->first();
        if (!$privacy) {
            return new DataSuccess(
                data: null,
                status: true,
                message: __("messages.no_data_found")
            );
        }

        return new DataSuccess(
            data: new PrivacyResource($privacy),
            status: true,
            message: __("messages.data_retrieved_successfully")
        );
    }
}

