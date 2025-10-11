<?php

namespace App\Modules\Admin\app\Services\Plans;

use App\Modules\Admin\app\Models\Feature\Feature;
use App\Modules\Base\app\Services\BaseService;

class FeatureService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Feature::class));
    }
}
