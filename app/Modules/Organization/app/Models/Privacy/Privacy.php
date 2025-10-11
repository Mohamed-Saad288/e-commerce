<?php

namespace App\Modules\Organization\app\Models\Privacy;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Privacy extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['description'];

    protected $table = 'privacy';

    protected $fillable = [
        'organization_id',
        'employee_id',
    ];
}
