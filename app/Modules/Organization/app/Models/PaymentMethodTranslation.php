<?php

namespace App\Modules\Organization\app\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];
}
