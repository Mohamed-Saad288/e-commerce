<?php

namespace App\Modules\Organization\app\Models\Header;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Header extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected $table = 'headers';

    protected $fillable = [
        'image',
        'organization_id',
        'employee_id',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(HeaderImage::class, 'header_id');
    }
}
