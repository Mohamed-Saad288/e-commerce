<?php

namespace App\Modules\Organization\app\Models\Brand;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Category\Category;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Brand extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected $table = 'brands';

    protected $fillable = [
        'slug',
        'organization_id',
        'employee_id',
        'organization_id',
        'employee_id',
        'image',
    ];

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class, 'brand_categories', 'brand_id', 'category_id');
    }

    public function productVariations() : hasManyThrough
    {

    }
}
