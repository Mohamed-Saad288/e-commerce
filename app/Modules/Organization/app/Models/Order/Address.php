<?php

namespace App\Modules\Organization\app\Models\Order;

use App\Models\User;
use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\City\City;
use App\Modules\Organization\app\Models\Country\Country;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends BaseModel
{
    protected $table = 'addresses';

    protected $fillable = [
        'country_id',
        'city_id',
        'address1',
        'address2',
        'postcode',
        'type',
        'user_id',
        'is_default',
        'phone',
    ];

    public function orderShipping(): \Illuminate\Database\Eloquent\Relations\HasOne|Address
    {
        return $this->hasOne(Order::class, 'shipping_address_id');
    }

    public function orderBilling(): \Illuminate\Database\Eloquent\Relations\HasOne|Address
    {
        return $this->hasOne(Order::class, 'billing_address_id');
    }

    public function fullAddress(): string
    {
        $components = [
            $this->address1,
            $this->address2,
            $this->city ? $this->city->name : null,
            $this->country ? $this->country->name : null,
            $this->postcode,
        ];

        return implode(', ', array_filter($components));
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
