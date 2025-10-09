<?php

namespace App\Modules\Organization\Enums\Product;

enum ProductTypeEnum: int
{
    case physical = 1;
    case digital = 2;
    case service = 3;

}
