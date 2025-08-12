<?php

namespace App\Modules\Admin\app\Models\Plans;

use App\Modules\Admin\app\Models\Feature\Feature;
use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name','description'];

    protected $table = 'plans';

    protected $fillable = [
        'slug',
        'price',
        'sort_order',
        'billing_type',
        'duration',
        'trial_period',
        'added_by_id',
        'is_active',
    ];


    public function featurePlans()
    {
        return $this->hasMany(FeaturePlan::class);
    }

    public function features() : BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'feature_plans', 'plan_id', 'feature_id');
    }
}
