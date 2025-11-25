<?php

namespace App\Modules\Website\app\Http\Controllers\Term;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Services\Term\TermService;

class TermController extends Controller
{
    public function __construct(protected TermService $service)
    {
    }

    public function fetch_terms()
    {
        return $this->service->fetchTerms()->response();
    }
}
