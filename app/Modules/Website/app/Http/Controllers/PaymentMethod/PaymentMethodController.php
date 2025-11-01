<?php

namespace App\Modules\Website\app\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Services\PaymentMethod\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function __construct(protected PaymentMethodService $service) {}

    public function __construct(protected PaymentMethodService $service) {}

    public function index(Request $request)
    {
        return $this->service->index($request)->response();
    }
}
