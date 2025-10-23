<?php

namespace App\Modules\Website\app\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\DTO\Order\OrderDto;
use App\Modules\Website\app\Http\Request\Order\StoreOrderRequest;
use App\Modules\Website\app\Services\Order\OrderService;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service) {}

    public function store(StoreOrderRequest $request)
    {
        $dto = OrderDto::fromArray([...$request->validated(), 'user_id' => auth()->id()]);
        $order = $this->service->store($dto);

        return response()->json(['data' => $order], 201);
    }
}
