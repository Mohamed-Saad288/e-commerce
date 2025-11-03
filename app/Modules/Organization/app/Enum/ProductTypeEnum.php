<?php

namespace App\Modules\Organization\app\Enum;

enum ProductTypeEnum: int
{
    case PHYSICAL = 1;
    case DIGITAL = 2;

    case SERVICE = 3;
}
