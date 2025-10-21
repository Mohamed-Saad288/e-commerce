<?php

namespace App\Modules\Organization\Enums\Coupon;

enum CouponTypeEnum : int
{
    case PERCENTAGE = 1;
    case FIXED_AMOUNT = 2;
    case FREE_SHIPPING = 3;
}
