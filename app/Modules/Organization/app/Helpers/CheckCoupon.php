<?php
function validateCouponForUser($coupon, $userId)
{
    if (! $coupon->isValid()) {
        return false;
    }

    if (! $coupon->isValidForUser($userId)) {
        return false;
    }

    return true;
}
