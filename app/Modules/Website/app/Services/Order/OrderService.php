<?php

namespace App\Modules\Website\app\Services\Order;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class OrderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Order::class));
    }
    public function store(DtoInterface $dto): Model
    {
        $order = Parent::store($dto);
        $order->orderItems()->createMany($dto->orderItems);

    }
}
