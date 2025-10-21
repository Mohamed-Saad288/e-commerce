<?php

namespace App\Modules\Organization\app\Services\Coupon;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Coupon\Coupon;

class CouponService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Coupon::class));
    }
}
