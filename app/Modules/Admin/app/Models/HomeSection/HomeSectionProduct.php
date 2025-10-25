<?php

namespace App\Modules\Admin\app\Models\HomeSection;

use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeSectionProduct extends Model
{
    protected $table = 'home_section_products';

    protected $fillable = [
        'home_section_id',
        'product_variation_id',
        'sort_order',
    ];

    public function homeSection(): BelongsTo
    {
        return $this->belongsTo(HomeSection::class, 'home_section_id');
    }

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(productVariation::class, 'product_variation_id');
    }
}
