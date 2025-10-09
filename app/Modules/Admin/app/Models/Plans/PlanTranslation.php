<?php

namespace App\Modules\Admin\app\Models\Plans;

use Illuminate\Database\Eloquent\Model;

class PlanTranslation extends Model
{
    protected $table = 'plan_translations';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'locale',
        'plan_id',
    ];
}
