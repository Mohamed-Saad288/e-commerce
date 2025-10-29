<?php

namespace App\Modules\Organization\app\Models\Coupon;

use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }
    public function isValid()
    {
        return $this->is_active
            && ($this->start_date === null || now()->greaterThanOrEqualTo($this->start_date))
            && ($this->end_date === null || now()->lessThanOrEqualTo($this->end_date))
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }
    public function isValidForUser($userId): bool
    {
        return ! $this->usages()
            ->where('user_id', $userId)
            ->exists();
    }

}
