<?php

namespace App\Modules\Organization\app\Models\Category;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Product\Product;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

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
        'image',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany|Category
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'brand_categories', 'category_id', 'brand_id');
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    // Recursive relationship
    public function allSubCategories()
    {
        return $this->subCategories()->with('allSubCategories');
    }

    public function getTreeAttribute(): Category
    {
        return $this->loadMissing('allSubCategories');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function productVariations(): HasManyThrough
    {
        return $this->hasManyThrough(ProductVariation::class, Product::class, 'category_id', 'product_id');
    }

    public function getSubCategoriesProducts(): Collection
    {
        $subCategoryIds = $this->subCategories()->pluck('id')->toArray();

        if (empty($subCategoryIds)) {
            return collect();
        }

        return ProductVariation::whereHas('product', function ($query) use ($subCategoryIds) {
            $query->whereIn('category_id', $subCategoryIds);
        })->get();
    }

    public function getAllSubCategoryIds(): array
    {
        $ids = $this->subCategories()->pluck('id')->toArray();

        foreach ($this->subCategories as $subCategory) {
            $ids = array_merge($ids, $subCategory->getAllSubCategoryIds());
        }

        return $ids;
    }

    public function getSubCategoriesIds(): array
    {
        return $this->subCategories()->pluck('id')->toArray();
    }

    public function getFinalProducts(?int $limit = null)
    {
        $ownVariationsQuery = $this->productVariations();

        if ($ownVariationsQuery->exists()) {
            return $limit
                ? $ownVariationsQuery->limit($limit)->get()
                : $ownVariationsQuery->get();
        }

        $subCategoryIds = $this->getSubCategoriesIds();

        if (empty($subCategoryIds)) {
            return collect();
        }

        $query = ProductVariation::whereHas('product', function ($query) use ($subCategoryIds) {
            $query->whereIn('category_id', $subCategoryIds);
        });

        return $limit
            ? $query->limit($limit)->get()
            : $query->get();
    }
}
