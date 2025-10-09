<?php

namespace App\Modules\Website\app\Http\Controllers\Privacy;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Services\Privacy\PrivacyService;

class PrivacyController extends Controller
{
    public function __construct(protected PrivacyService $service){}
    protected function fetch_privacy()
    {
        return $this->service->fetchPrivacy()->response();
    }
}
