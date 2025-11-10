<?php

namespace App\Modules\Website\app\Services\Payment;

use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Order\Payment;
use App\Modules\Website\app\Http\Resources\PaymentMethod\PaymentMethodResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Payment::class));
    }
}
