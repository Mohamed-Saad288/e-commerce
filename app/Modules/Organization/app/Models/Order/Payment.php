<?php

namespace App\Modules\Organization\app\Models\Order;

use App\Models\User;
use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    protected $fillable = ['order_id', 'user_id', 'payment_method_id', 'status', 'amount', 'transaction_id', 'currency', 'meta', 'organization_id', 'employee_id', 'is_active'];

    //    ================================================================================================================> Relations

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
