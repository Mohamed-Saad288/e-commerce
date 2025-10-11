<?php

namespace App\Modules\Organization\app\Models\ProductVariation;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariationOptionItem extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'product_variation_option_items';

    protected $fillable = [
        'product_variation_id',
        'option_item_id',
        'organization_id',
        'employee_id',
    ];

    public function optionItem(): BelongsTo
    {
        return $this->belongsTo(OptionItem::class, 'option_item_id');
    }

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
