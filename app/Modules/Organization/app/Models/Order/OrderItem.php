<?php

namespace App\Modules\Organization\app\Models\Order;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Product\Product;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends BaseModel
{

    protected $table = 'order_items';

    protected $fillable = [
        'product_id',
        'quantity',
        'product_variation_id',
        'price',
        'sub_total',
        'discount_amount',
        'tax_amount',
        'tax_type',
        'total_amount',
        'organization_id',
        'order_id'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function productVariation():BelongsTo
    {
        return $this->belongsTo(ProductVariation::class , 'product_variation_id');
    }

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class , 'order_id');
    }
}
