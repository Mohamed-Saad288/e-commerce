<?php

namespace App\Modules\Admin\app\Models\Plans;

use App\Modules\Admin\app\Models\Feature\Feature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturePlan extends Model
{

    protected $table = 'feature_plans';

    protected $fillable = [
        'feature_id',
        'plan_id',
        'feature_value',
        'is_active'
    ];

    public function feature() : BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

}
