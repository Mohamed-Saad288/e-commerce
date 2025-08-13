<?php

namespace App\Modules\Organization\app\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\DTO\BrandDto;
use App\Modules\Organization\app\Http\Request\Brand\StoreBrandRequest;
use App\Modules\Organization\app\Http\Request\Brand\UpdateBrandRequest;
use App\Modules\Organization\app\Models\Brand\Brand;
use Exception;

class BrandController extends Controller
{
    public function __construct(protected BaseService $service){}

    public function index()
    {
        $brands = $this->service->index();
        return view('organization::dashboard.brands.index', get_defined_vars());
    }
    public function create()
    {
        return view('organization::dashboard.brands.single',get_defined_vars());
    }
    public function store(StoreBrandRequest $request)
    {
         $this->service->store(BrandDto::fromArray($request));
        return to_route('organization.brands.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }
    public function edit(Brand $brand)
    {

        return view('organization::dashboard.brands.single', get_defined_vars());
    }
    public function update(UpdateBrandRequest $request , Brand $brand)
    {
        $this->service->update(model: $brand, dto: BrandDto::fromArray($request));

        return to_route('organization.brands.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }
    public function destroy(Brand $brand)
    {
        try {
            $this->service->delete(model: $brand);
            return response()->json([
                'success' => true,
                'message' => __('messages.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong')
            ], 500);
        }
    }


}
