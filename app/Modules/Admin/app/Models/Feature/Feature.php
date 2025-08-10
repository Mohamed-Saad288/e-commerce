<?php

namespace App\Modules\Admin\app\Models\Feature;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Feature extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name','description'];

    protected $table = "features";

    protected $fillable = ['type',"slug","is_active","added_by_id"];

}
