<?php

namespace App\Modules\Organization\app\Models\City;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Country\Country;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends BaseModel implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $table = 'cities';

    protected $fillable = ['country_id', 'is_active'];

    public array $translatedAttributes = ['name'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
