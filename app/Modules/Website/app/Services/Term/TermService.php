<?php

namespace App\Modules\Website\app\Services\Term;

use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Term\Term;
use App\Modules\Website\app\Http\Resources\Term\TermResource;

class TermService
{
    public function fetchTerms(): DataSuccess
    {

        $term = Term::query()->first();

        if (! $term) {
            return new DataSuccess(
                data: null,
                status: true,
                message: __('messages.no_data_found')
            );
        }

        return new DataSuccess(
            data: new TermResource($term),
            status: true,
            message: __('messages.data_retrieved_successfully')
        );
    }
}
