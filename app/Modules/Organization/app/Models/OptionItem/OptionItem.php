<?php

namespace App\Modules\Organization\app\Models\OptionItem;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OptionItem extends BaseModel implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'option_id',
        'organization_id',
        'employee_id',
    ];

    protected $table = 'option_items';

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function productVariation(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariation::class,
            'product_variation_option_items',
            'option_item_id',
            'product_variation_id'
        );
    }
}
