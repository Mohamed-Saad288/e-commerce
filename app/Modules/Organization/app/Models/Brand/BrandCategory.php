<?php

namespace App\Modules\Organization\app\Models\Brand;

use App\Modules\Organization\app\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandCategory extends Model
{
    protected $table = 'brand_categories';

    protected $fillable = [
        'brand_id',
        'category_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
