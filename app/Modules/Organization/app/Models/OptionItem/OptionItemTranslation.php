<?php

namespace App\Modules\Organization\app\Models\OptionItem;

use Illuminate\Database\Eloquent\Model;

class OptionItemTranslation extends Model
{
    protected $table = 'option_item_translations';

    public $timestamps = false;

    protected $fillable = ['name', 'option_item_id', 'locale'];
}
