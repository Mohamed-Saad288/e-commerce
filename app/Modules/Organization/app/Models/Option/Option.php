<?php

namespace App\Modules\Organization\app\Models\Option;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends  BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name'];

    protected $table = 'options';
    protected $fillable = ['organization_id',"employee_id"];

}
