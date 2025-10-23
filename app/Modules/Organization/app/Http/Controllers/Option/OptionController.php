<?php

namespace App\Modules\Organization\app\Http\Controllers\Option;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Option\OptionDto;
use App\Modules\Organization\app\Http\Request\Option\StoreOptionRequest;
use App\Modules\Organization\app\Http\Request\Option\UpdateOptionRequest;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Services\Option\OptionService;
use Exception;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct(protected OptionService $service) {}

    public function index(Request $request)
    {
        $query = Option::whereOrganizationId(auth('organization_employee')->user()->organization_id);

        if ($request->ajax()) {
            if ($request->filled('search')) {
                $query->whereTranslationLike('name', '%'.$request->search.'%');
            }

            $options = $query->latest()->paginate(10);

            return view('organization::dashboard.options.partials._table', compact('options'))->render();
        }

        $options = $query->latest()->paginate(10);

        return view('organization::dashboard.options.index', compact('options'));
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
