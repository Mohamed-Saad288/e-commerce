<?php

namespace App\Modules\Organization\app\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use Translatable;

    protected $fillable = [
        'code',
        'icon',
        'is_active',
        'required_settings',
    ];

    public array $translatedAttributes = [
        'name',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'required_settings' => 'array',
    ];

    /**
     * Get all organizations using this payment method
     */
    public function organizationPaymentMethods(): HasMany
    {
        return $this->hasMany(OrganizationPaymentMethod::class);
    }
}
