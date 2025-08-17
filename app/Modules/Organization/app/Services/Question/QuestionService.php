<?php

namespace App\Modules\Organization\app\Services\Question;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Organization\app\Models\Question\Question;

class QuestionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Question::class));
    }
}
