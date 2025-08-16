<?php

namespace App\Modules\Organization\app\Services\OptionItem;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;

class OptionItemService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(OptionItem::class));
    }
}
