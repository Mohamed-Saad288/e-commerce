<?php

namespace App\Modules\Organization\app\Models\Cart;

use App\Models\User;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'product_variation_id',
        'user_id',
        'organization_id',
        'quantity',
        'price',
        'cart_id'
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

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }
}
