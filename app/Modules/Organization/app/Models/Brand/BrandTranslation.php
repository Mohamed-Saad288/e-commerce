<?php

namespace App\Modules\Organization\app\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    protected $table = 'brand_translations';

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'description', 'locale'];
}
