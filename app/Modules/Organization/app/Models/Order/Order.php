<?php

namespace App\Modules\Organization\app\Models\Order;

use App\Models\User;
use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Coupon\Coupon;
use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'billing_address_id',
        'payment_method_id',
        'order_number',
        'status',
        'sub_total',
        'tax_amount',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'notes',
    ];

    //    =====================================================================================================>Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
