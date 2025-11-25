<?php

namespace App\Modules\Organization\app\Http\Controllers\Why;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Why\WhyDto;
use App\Modules\Organization\app\Http\Request\Why\StoreWhyRequest;
use App\Modules\Organization\app\Http\Request\Why\UpdateWhyRequest;
use App\Modules\Organization\app\Models\Why\Why;
use App\Modules\Organization\app\Services\Why\WhyService;
use Exception;

class WhyController extends Controller
{
    public function __construct(protected WhyService $service)
    {
    }

    public function index()
    {
        $whys = $this->service->index();

        return view('organization::dashboard.whys.index', get_defined_vars());
    }

    public function create()
    {
        return view('organization::dashboard.whys.single', get_defined_vars());
    }

    public function store(StoreWhyRequest $request)
    {
        $this->service->store(WhyDto::fromArray($request));

        return to_route('organization.whys.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Why $why)
    {
        return view('organization::dashboard.whys.single', get_defined_vars());
    }

    public function update(UpdateWhyRequest $request, Why $why)
    {
        $this->service->update(model: $why, dto: WhyDto::fromArray($request));

        return to_route('organization.whys.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Why $why)
    {
        try {
            $this->service->delete(model: $why);

            return response()->json([
                'success' => true,
                'message' => __('messages.deleted'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong'),
            ], 500);
        }
    }
}
