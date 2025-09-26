<?php

namespace App\Modules\Organization\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Admin\app\Models\Organization\Organization;

class OrganizationPaymentMethod extends Model
{
    protected $fillable = [
        'organization_id',
        'payment_method_id',
        'is_active',
        'sort_order',
        'credentials',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the organization that owns this payment method
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the payment method
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
