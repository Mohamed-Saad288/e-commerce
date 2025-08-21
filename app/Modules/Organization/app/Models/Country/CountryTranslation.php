<?php

namespace App\Modules\Organization\app\Models\Country;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    protected $guarded = ['id'];

    protected $table = 'country_translations';
}
