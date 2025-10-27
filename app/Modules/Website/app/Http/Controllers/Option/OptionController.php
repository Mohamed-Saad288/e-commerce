<?php

namespace App\Modules\Website\app\Http\Controllers\Option;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Website\app\Http\Resources\Option\OptionResource;
use App\Modules\Website\app\Services\Option\OptionService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct(protected OptionService $service) {}

    public function index(Request $request)
    {
        $result = $this->service->index($request);

        return (new DataSuccess(
            data: OptionResource::collection($result), status: true,
            message: __('messages.data_retrieved_successfully')
        ))->response();
    }
}
