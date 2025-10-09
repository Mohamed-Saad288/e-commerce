<?php

namespace App\Modules\Organization\app\Models\Question;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Question extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['question', 'answer'];

    protected $table = 'questions';

    protected $fillable = [
        'organization_id',
        'employee_id',
        "sort_order",
        'is_active'
    ];
}
