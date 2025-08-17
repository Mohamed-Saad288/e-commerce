<?php

namespace App\Modules\Organization\app\Services\Term;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Organization\app\Models\Term\Term;

class TermService extends BaseService
{
    public function __construct()
    {
        parent::__construct(model: resolve(Term::class));
    }
}
