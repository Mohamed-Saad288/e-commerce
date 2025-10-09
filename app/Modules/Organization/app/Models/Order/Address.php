<?php

namespace App\Modules\Organization\app\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'country_id',
        'city_id',
        'address1',
        'address2',
        'Postcode',
        'type',
        'user_id',
        'is_default',
    ];
}
