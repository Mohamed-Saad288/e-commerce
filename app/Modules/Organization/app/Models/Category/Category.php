<?php

namespace App\Modules\Organization\app\Models\Category;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Product\Product;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function brands(): BelongsToMany
    {
        return $this->BelongsToMany(Brand::class, 'brand_categories', 'category_id', 'brand_id');
    }

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\HasMany|Category
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    //  Recursive relationship
    public function allSubCategories()
    {
        return $this->subCategories()->with('allSubCategories');
    }

    public function getTreeAttribute(): Category
    {
        return $this->load('allSubCategories');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
