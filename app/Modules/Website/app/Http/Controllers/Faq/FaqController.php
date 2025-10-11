<?php

namespace App\Modules\Website\app\Http\Controllers\Faq;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Services\Faq\FaqService;

class FaqController extends Controller
{
    public function __construct(protected FaqService $service) {}

    public function fetch_faqs()
    {
        return $this->service->fetchFaqs()->response();
    }
}
