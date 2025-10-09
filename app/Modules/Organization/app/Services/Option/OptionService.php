<?php

namespace App\Modules\Organization\app\Services\Option;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Option\Option;

class OptionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Option::class));
    }
}
