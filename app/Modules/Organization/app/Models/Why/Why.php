<?php

namespace App\Modules\Organization\app\Models\Why;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Why extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected $table = 'why';

    protected $fillable = [
        'image',
        'organization_id',
        'employee_id',
        'sort_order',
        'is_active',
    ];
}
