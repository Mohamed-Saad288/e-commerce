<?php

namespace App\Modules\Website\app\Http\Controllers\Faq;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Website\app\Services\Faq\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct(protected FaqService $service){}

    public function fetch_faqs(Request $request)
    {
        return $this->service->fetchFaqs($request)->response();
    }
}
