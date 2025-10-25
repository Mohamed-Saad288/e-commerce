<?php

namespace App\Modules\Organization\app\Models\Cart;

use App\Models\User;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Organization\app\Models\Coupon\Coupon;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'organization_id',
        'total',
        'coupon_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_items', 'cart_id', 'product_variation_id')
            ->withPivot('price', 'quantity');
    }
}
