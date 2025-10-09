<?php

namespace App\Modules\Organization\Enums\Product;

enum TaxTypeEnum: int
{
    case amount = 1;
    case percentage = 2;
}
