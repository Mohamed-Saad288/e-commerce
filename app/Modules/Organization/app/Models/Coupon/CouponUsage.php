<?php

namespace App\Modules\Organization\app\Models\Coupon;

use App\Models\User;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponUsage extends BaseModel
{
    protected $table = 'coupon_usages';

    protected $fillable = [
        'organization_id',
        'coupon_id',
        'user_id',
        'used_at',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
