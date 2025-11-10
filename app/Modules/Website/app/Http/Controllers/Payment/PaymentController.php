<?php

namespace App\Modules\Website\app\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Website\app\DTO\Payment\PaymentDto;
use App\Modules\Website\app\Http\Request\Payment\StorePaymentRequest;
use App\Modules\Website\app\Services\Payment\PaymentService;

class PaymentController extends Controller
{

    public function __construct(protected PaymentService $service) {}

    public function store(StorePaymentRequest $request)
    {
        $this->service->store(PaymentDto::fromArray($request));

        return (new DataSuccess(
            status: true,
            message: __("organizations.the_payment_added_successfully")
        ))->response();
    }
}
