<?php

namespace App\Modules\Website\app\Services\Faq;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Question\Question;
use App\Modules\Website\app\Http\Resources\Faq\FaqResource;
use Illuminate\Http\Request;

class FaqService
{
    public function fetchFaqs(?Request $request = null): DataSuccess
    {
        $faqs = Question::query()->limit($request->limit ?? 7)->get();
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
