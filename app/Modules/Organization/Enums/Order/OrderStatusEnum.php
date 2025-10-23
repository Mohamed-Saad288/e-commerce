<?php

namespace App\Modules\Organization\Enums\Order;

enum OrderStatusEnum: int
{
    case PENDING = 1;
    case PROCESSING = 2;

    case DELIVERED = 3;
    case CANCELLED = 4;
    case REFUNDED = 5;

    case COMPLETED = 6;
}
