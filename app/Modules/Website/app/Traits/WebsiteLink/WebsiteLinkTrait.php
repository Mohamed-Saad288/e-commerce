<?php

namespace App\Modules\Website\app\Traits\WebsiteLink;

use App\Modules\Admin\App\Models\Organization\Organization;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait WebsiteLinkTrait
{
    public function getOrganization(): Organization
    {
        $websiteLink = request()->header('website-link');

        if (empty($websiteLink)) {
            throw new BadRequestHttpException('The "website-link" header is required.');
        }

        $organization = Organization::where('website_link', $websiteLink)->first();

        if (!$organization) {
            throw new NotFoundHttpException('Organization not found for the provided website link.');
        }

        return $organization;
    }
}
