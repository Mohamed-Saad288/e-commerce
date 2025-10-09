<?php

namespace App\Modules\Organization\app\Models\Country;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\City\City;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends BaseModel implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $table = 'countries';

    protected $fillable = ['is_active'];

    public array $translatedAttributes = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
