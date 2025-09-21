<?php

namespace App\Modules\Organization\app\Models\Product;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Base\app\Scopes\TenantScope;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends  BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description' , "short_description"];

    protected $table = 'products';

    protected $fillable = [
      "slug",
      "brand_id",
      "category_id",
      "sort_order",
      "sku",
      "barcode",
      "type",
      "stock_quantity",
      "low_stock_threshold",
      "requires_shipping",
      "is_featured",
      "is_taxable",
      "tax_type",
      "tax_amount",
      "discount",
      "cost_price",
      "selling_price",
      "total_price",
      "added_by_id",
      "organization_id",
      "employee_id",
        "is_active"
    ];


    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function variations() : HasMany
    {
        return $this->hasMany(ProductVariation::class , "product_id");
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class , "brand_id");
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class , "category_id");
    }


}
