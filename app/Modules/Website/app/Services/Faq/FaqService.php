<?php

namespace App\Modules\Website\app\Services\Faq;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Question\Question;
use App\Modules\Organization\app\Models\Term\Term;
use App\Modules\Website\app\Http\Resources\Faq\FaqResource;
use App\Modules\Website\app\Http\Resources\Term\TermResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class FaqService
{
    use WebsiteLinkTrait;
    public function fetchFaqs(): DataSuccess
    {
        $organization = $this->getOrganization();

        $faqs = Question::where('organization_id', $organization->id)->limit(7)->get();
        return new DataSuccess(
            data:  FaqResource::collection($faqs),
            status: true,
            message: 'Terms fetched successfully.'
        );
    }
}

