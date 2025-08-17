<?php

namespace App\Modules\Organization\app\Services\Why;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\About\About;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Organization\app\Models\Why\Why;

class WhyService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Why::class));
    }
}
