<?php

namespace App\Modules\Organization\app\Models\FavouriteProduct;

use App\Models\User;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavouriteProduct extends Model
{
    protected $table = 'favourite_products';

    protected $fillable = [
        'product_variation_id',
        'user_id',
        'organization_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
