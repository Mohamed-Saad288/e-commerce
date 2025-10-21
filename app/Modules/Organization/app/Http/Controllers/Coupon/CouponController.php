<?php

namespace App\Modules\Organization\app\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Coupon\CouponDto;
use App\Modules\Organization\app\Http\Request\Coupon\StoreCouponRequest;
use App\Modules\Organization\app\Http\Request\Coupon\UpdateCouponRequest;
use App\Modules\Organization\app\Models\Coupon\Coupon;
use App\Modules\Organization\app\Services\Coupon\CouponService;
use Exception;

class CouponController extends Controller
{
    public function __construct(protected CouponService $service) {}

    public function index()
    {
        $coupons = $this->service->index();

        return view('organization::dashboard.coupons.index', get_defined_vars());
    }

    public function create()
    {
        return view('organization::dashboard.coupons.single', get_defined_vars());
    }

    public function store(StoreCouponRequest $request)
    {
        $this->service->store(CouponDto::fromArray($request));

        return to_route('organization.coupons.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Coupon $coupon)
    {

        return view('organization::dashboard.coupons.single', get_defined_vars());
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->service->update(model: $coupon, dto: CouponDto::fromArray($request));

        return to_route('organization.coupons.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        try {
            $this->service->delete(model: $coupon);

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

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = ! $coupon->is_active;
        $coupon->save();

        return response()->json([
            'success' => true,
            'status' => $coupon->is_active,
            'message' => $coupon->is_active
                ? __('messages.coupon_activated')
                : __('messages.coupon_deactivated'),
        ]);
    }
}
