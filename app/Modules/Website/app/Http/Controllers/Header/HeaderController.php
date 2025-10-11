<?php

namespace App\Modules\Website\app\Http\Controllers\Header;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Services\Header\HeaderService;

class HeaderController extends Controller
{
    public function __construct(protected HeaderService $service){}

    public function fetch_header()
    {
        return $this->service->fetch_headers()->response();
    }
}
