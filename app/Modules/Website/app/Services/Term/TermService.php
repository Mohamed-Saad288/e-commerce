<?php

namespace App\Modules\Website\app\Services\Term;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Term\Term;
use App\Modules\Website\app\Http\Resources\Term\TermResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class TermService
{
    use WebsiteLinkTrait;

    public function fetchTerms(): DataSuccess
    {
        $organization = $this->getOrganization();

        $term = Term::where('organization_id', $organization->id)->first();

        if (!$term) {
            return new DataSuccess(
                data: null,
                status: true,
                message: 'Terms not stored yet.'
            );
        }

        return new DataSuccess(
            data: new TermResource($term),
            status: true,
            message: 'Terms fetched successfully.'
        );
    }
}

