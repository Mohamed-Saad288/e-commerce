<?php

namespace App\Modules\Organization\app\Models\Coupon;

use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends BaseModel
{
    protected $table = 'coupons';

    protected $fillable = [
        'organization_id',
        'code',
        'type',
        'value',
        'min_order_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
