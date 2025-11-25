<?php

namespace App\Modules\Website\app\Http\Controllers\WebStatus;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Services\WebStatus\WebStatusService;

class WebStatusController extends Controller
{
    public function __construct(protected WebStatusService $service)
    {
    }

    public function fetch_web_status()
    {
        return $this->service->fetch_Web_status()->response();
    }
}
