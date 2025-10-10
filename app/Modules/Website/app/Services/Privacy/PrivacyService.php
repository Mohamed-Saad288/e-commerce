<?php

namespace App\Modules\Website\app\Services\Privacy;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Privacy\Privacy;
use App\Modules\Website\app\Http\Resources\Privacy\PrivacyResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class PrivacyService
{
    use WebsiteLinkTrait;

    public function fetchPrivacy(): DataSuccess
    {
        $organization = $this->getOrganization();

        $privacy = Privacy::where('organization_id', $organization->id)->first();
        if (!$privacy) {
            return new DataSuccess(
                data: null,
                status: true,
                message: 'Privacy not stored yet.'
            );
        }

        return new DataSuccess(
            data: new PrivacyResource($privacy),
            status: true,
            message: 'Privacy fetched successfully.'
        );
    }
}

