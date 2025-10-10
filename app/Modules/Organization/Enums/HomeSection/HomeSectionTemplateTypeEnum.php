<?php

namespace App\Modules\Organization\Enums\HomeSection;

enum HomeSectionTemplateTypeEnum : int
{
    case Best_Sellers = 1;
    case Trending = 2;
    case Special_Offer = 3;
    case New_Collection = 4;
    case Top_Rated = 5;
    case Featured_Products = 6;
}
