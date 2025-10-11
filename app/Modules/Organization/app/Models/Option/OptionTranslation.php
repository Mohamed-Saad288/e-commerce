<?php

namespace App\Modules\Organization\app\Models\Option;

use Illuminate\Database\Eloquent\Model;

class OptionTranslation extends Model
{
    protected $table = 'option_translations';

    public $timestamps = false;

    protected $fillable = ['name'];
}
