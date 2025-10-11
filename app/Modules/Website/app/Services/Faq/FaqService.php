<?php

namespace App\Modules\Website\app\Services\Faq;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Question\Question;
use App\Modules\Website\app\Http\Resources\Faq\FaqResource;

class FaqService
{
    public function fetchFaqs(): DataSuccess
    {

        $faqs = Question::query()->limit(7)->get();
        if (! $faqs || $faqs->isEmpty()) {
            return new DataSuccess(
                data: null,
                status: true,
                message: __('messages.no_data_found')
            );
        }

        return new DataSuccess(
            data: FaqResource::collection($faqs),
            status: true,
            message: __('messages.data_retrieved_successfully')
        );
    }
}
