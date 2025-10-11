<?php

namespace App\Modules\Website\app\Services\Header;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Website\app\Http\Resources\Header\HeaderResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class HeaderService
{
    use WebsiteLinkTrait;

    public function fetch_headers()
    {
        $organization = $this->getOrganization();
        $headers = Header::where('organization_id', $organization->id)->first();
        if (! $headers) {
            return new DataSuccess(
                data: null,
                status: true,
                message: 'Headers not stored yet.'
            );
        }

        return new DataSuccess(
            data: new HeaderResource($headers),
            status: true,
            message: 'Headers fetched successfully.'
        );
    }
}
