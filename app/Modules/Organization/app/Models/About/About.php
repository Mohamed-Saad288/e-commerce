<?php

namespace App\Modules\Organization\app\Models\About;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class About extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected $table = 'about';

    protected $fillable = [
        'image',
        'organization_id',
        'employee_id',
        "sort_order",
        'is_active'
    ];
}
