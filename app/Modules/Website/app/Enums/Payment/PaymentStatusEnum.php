<?php

namespace App\Modules\Website\app\Enums\Payment;

enum PaymentStatusEnum: int
{
    case PENDING = 1;
    case COMPLETED = 2;
    case FAILED = 3;

    case REFUNDED = 4;
}
