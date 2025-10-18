<?php

namespace App\Modules\Organization\app\Http\Controllers\HomeSection;

use App\Http\Controllers\Controller;
use App\Modules\Admin\app\Models\HomeSection\HomeSection;
use App\Modules\Organization\app\DTO\HomeSection\HomeSectionDto;
use App\Modules\Organization\app\Http\Request\HomeSection\StoreHomeSectionRequest;
use App\Modules\Organization\app\Http\Request\HomeSection\UpdateHomeSectionRequest;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use App\Modules\Organization\app\Services\HomeSection\HomeSectionService;
use Exception;

class HomeSectionController extends Controller
{
    public function __construct(protected HomeSectionService $service) {}

    public function index()
    {
        $home_sections = HomeSection::whereOrganizationId(auth()->user()->organization_id)->orderBy('sort_order', 'asc')->paginate(10);

        return view('organization::dashboard.home_sections.index', get_defined_vars());
    }

    public function create()
    {
        $products = ProductVariation::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.home_sections.single', get_defined_vars());
    }

    public function store(StoreHomeSectionRequest $request)
    {
        $this->service->store(HomeSectionDto::fromArray($request));

        return to_route('organization.home_sections.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(HomeSection $home_section)
    {
        $products = ProductVariation::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.home_sections.single', get_defined_vars());
    }

    public function update(UpdateHomeSectionRequest $request, HomeSection $home_section)
    {
        $this->service->update(model: $home_section, dto: HomeSectionDto::fromArray($request));

        return to_route('organization.home_sections.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(HomeSection $home_section)
    {
        try {
            $this->service->delete(model: $home_section);

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
