<?php

namespace App\Modules\Admin\Enums\Plan;

enum BillingTypeEnum : int
{
    case MONTHLY = 1;
    case YEARLY = 2;

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
        };
    }
}
