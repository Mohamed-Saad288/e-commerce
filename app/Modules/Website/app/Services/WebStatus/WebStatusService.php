<?php

namespace App\Modules\Website\app\Services\WebStatus;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\OrganizationSetting\OrganizationSetting;
use App\Modules\Website\app\Http\Resources\WebStatus\WebStatusResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class WebStatusService
{
    use WebsiteLinkTrait;

    public function fetch_Web_status()
    {
        $organization = $this->getOrganization();

        $organization_setting = OrganizationSetting::where('organization_id', $organization->id)->first();

        if (! $organization_setting) {
            return new DataSuccess(
                data: null,
                status: true,
                message: 'organization setting not stored yet.'
            );
        }

        return new DataSuccess(
            data: new WebStatusResource($organization_setting),
            status: true,
            message: 'organization setting fetched successfully.'
        );
    }
}
