<?php

namespace App\Modules\Admin\app\Models\Plans;

use Illuminate\Database\Eloquent\Model;

class FeaturePlan extends Model
{

    protected $table = 'feature_plans';

    protected $fillable = [
        'feature_id',
        'plan_id',
        'feature_value',
        'is_active'
    ];

}
