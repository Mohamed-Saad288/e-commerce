<?php

namespace App\Modules\Organization\app\Services\About;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\About\About;

class AboutService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(About::class));
    }
}
