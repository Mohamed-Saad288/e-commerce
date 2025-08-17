<?php

namespace App\Modules\Organization\app\Services\Header;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;

class HeaderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Header::class));
    }
}
