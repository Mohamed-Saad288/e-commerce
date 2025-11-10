<?php

namespace App\Modules\Website\app\Services\Payment;

use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Order\Payment;

class PaymentService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Payment::class));
    }
}
