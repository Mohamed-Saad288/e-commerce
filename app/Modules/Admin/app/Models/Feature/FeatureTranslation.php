<?php

namespace App\Modules\Admin\app\Models\Feature;

use Illuminate\Database\Eloquent\Model;

class FeatureTranslation extends Model
{
    protected $table = 'feature_translations';

    public $timestamps = false;

    protected $fillable = [
        'feature_id',
        'locale',
        'name',
        'description',
    ];
}
