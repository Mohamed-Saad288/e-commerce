<?php

namespace App\Modules\Organization\app\Models\ProductVariation;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use App\Modules\Organization\app\Models\Product\Product;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ProductVariation extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name'];

    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'sku',
        'barcode',
        'stock_quantity',
        'is_featured',
        'is_taxable',
        'tax_type',
        'tax_amount',
        'discount',
        'cost_price',
        'selling_price',
        'total_price',
        'added_by_id',
        'organization_id',
        'employee_id',
    ];

    public function option_items(): BelongsToMany
    {
        return $this->belongsToMany(
            OptionItem::class,
            'product_variation_option_items',
            'product_variation_id',
            'option_item_id'
        )->withTimestamps();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category() : hasOneThrough
    {
        return $this->hasOneThrough(Category::class, Product::class, 'id', 'id', 'product_id', 'category_id');
    }

    public function brand():hasOneThrough
    {
        return $this->hasOneThrough(Brand::class, Product::class, 'id', 'id', 'product_id', 'brand_id');
    }
}
