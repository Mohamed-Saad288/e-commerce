<?php

namespace App\Modules\Organization\Enums\Address;

enum AddressEnum : int
{
    case SHIPPING = 1;
    case BILLING = 2;

    public function label(): string
    {
        return match ($this) {
            self::SHIPPING => 'Shipping',
            self::BILLING => 'Billing',
        };
    }
}
