<?php

namespace App\Modules\Website\app\Http\Controllers\WebsiteContent;

use App\Http\Controllers\Controller;
use App\Modules\Base\Application\Response\DataSuccess;
use App\Modules\Organization\app\Services\Header\HeaderService;
use App\Modules\Website\app\Http\Resources\WebsiteContent\HeaderResource;

class HeaderController extends Controller
{
    public function __construct (protected HeaderService $service)
    {
    }

    public function index()
    {
        $headers = $this->service->index();
        return (new DataSuccess(data: HeaderResource::collection($headers), status: 200, message: __('messages.success')))->response();
    }

    public function list()
    {
        $headers = $this->service->list();
        return (new DataSuccess(data: HeaderResource::collection($headers), status: 200, message: __('messages.success')))->response();
    }
}
