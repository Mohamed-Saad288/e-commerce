<?php

namespace App\Modules\Organization\app\Http\Controllers\Option;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Option\OptionDto;
use App\Modules\Organization\app\Http\Request\Option\StoreOptionRequest;
use App\Modules\Organization\app\Http\Request\Option\UpdateOptionRequest;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Services\Option\OptionService;
use Exception;

class OptionController extends Controller
{
    public function __construct(protected OptionService $service) {}

    public function index()
    {
        $options = $this->service->index();

        return view('organization::dashboard.options.index', get_defined_vars());
    }

    public function create()
    {
        return view('organization::dashboard.options.single', get_defined_vars());
    }

    public function store(StoreOptionRequest $request)
    {
        $this->service->store(OptionDto::fromArray($request));

        return to_route('organization.options.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Option $option)
    {
        return view('organization::dashboard.options.single', get_defined_vars());
    }

    public function update(UpdateOptionRequest $request, Option $option)
    {
        $this->service->update(model: $option, dto: OptionDto::fromArray($request));

        return to_route('organization.options.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Option $option)
    {
        try {
            $this->service->delete(model: $option);

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
