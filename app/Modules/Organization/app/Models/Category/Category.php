<?php

namespace App\Modules\Organization\app\Models\Category;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Base\app\Scopes\TenantScope;
use App\Modules\Organization\app\Models\Brand\Brand;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'sort_order',
        'slug',
        'organization_id',
        'employee_id',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function brands(): BelongsToMany
    {
        return $this->BelongsToMany(Brand::class, 'brand_categories', 'category_id', 'brand_id');
    }
}
