<?php

namespace App\Modules\Admin\app\Models\HomeSection;

use App\Modules\Organization\app\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeSectionProduct extends Model
{
    protected $table = 'home_section_products';

    protected $fillable = [
        'home_section_id',
        'product_id',
        'sort_order',
    ];

    public function homeSection(): BelongsTo
    {
        return $this->belongsTo(HomeSection::class, 'home_section_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
