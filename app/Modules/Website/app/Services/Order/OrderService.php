<?php

namespace App\Modules\Website\app\Services\Order;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Order\Address;
use App\Modules\Organization\app\Models\Order\Order;
use App\Modules\Organization\app\Models\Order\OrderItem;
use App\Modules\Website\app\DTO\Order\OrderDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Order::class));
    }

    public function store(DTOInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            /** @var Order $order */
            $order = parent::store($dto);

            $this->createOrderItems($order, $dto);
            $this->createAddresses($order, $dto);

            return $order->fresh(['orderItems', 'shippingAddress', 'billingAddress']);
        });
    }

    /**
     * Create order items for the order
     */
    private function createOrderItems(Order $order, OrderDto $dto): void
    {
        if (empty($dto->orderItems)) {
            return;
        }

        $orderItemsData = $this->prepareOrderItemsData($order, $dto);

        OrderItem::query()->insert($orderItemsData);
    }

    /**
     * Prepare order items data for bulk insertion
     */
    private function prepareOrderItemsData(Order $order, OrderDto $dto): array
    {
        return array_map(function ($item) use ($order, $dto) {
            $itemArray = $item->toArray();

            return array_merge($itemArray, [
                'order_id' => $order->id,
                'organization_id' => $dto->organization_id ?? $order->organization_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $dto->orderItems);
    }

    /**
     * Create shipping and billing addresses
     */
    private function createAddresses(Order $order, OrderDto $dto): void
    {
        $addressUpdates = [];

        if ($dto->shipping_address) {
            $shippingAddress = $this->createAddress($dto->shipping_address, $order);
            $addressUpdates['shipping_address_id'] = $shippingAddress->id;
        }

        if ($dto->billing_address) {
            $billingAddress = $this->createAddress($dto->billing_address, $order);
            $addressUpdates['billing_address_id'] = $billingAddress->id;
        }

        if (!empty($addressUpdates)) {
            $order->update($addressUpdates);
        }
    }

    /**
     * Create a single address record
     */
    private function createAddress($addressDto, Order $order): Address
    {
        $addressData = $addressDto->toArray();

        // Ensure address has necessary foreign keys
        $addressData = array_merge($addressData, [
            'organization_id' => $order->organization_id,
            'user_id' => $order->user_id,
        ]);

        return Address::query()->create($addressData);
    }

    /**
     * Update an existing order
     *
     * @param Model $model
     * @param DTOInterface $dto
     * @return Model
     * @throws Throwable
     */
    public function update(Model $model, DTOInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            /** @var Order $order */
            $order = parent::update($model, $dto);

            // Update order items if provided
            if (!empty($dto->orderItems)) {
                $this->updateOrderItems($order, $dto);
            }

            // Update addresses if provided
            $this->updateAddresses($order, $dto);

            return $order->fresh(['orderItems', 'shippingAddress', 'billingAddress']);
        });
    }

    /**
     * Update order items (delete existing and create new ones)
     */
    private function updateOrderItems(Order $order, OrderDto $dto): void
    {
        // Delete existing order items
        $order->orderItems()->delete();

        // Create new order items
        $this->createOrderItems($order, $dto);
    }

    /**
     * Update addresses for the order
     */
    private function updateAddresses(Order $order, OrderDto $dto): void
    {
        if ($dto->shipping_address) {
            $this->updateOrCreateAddress($order, $dto->shipping_address, 'shipping');
        }

        if ($dto->billing_address) {
            $this->updateOrCreateAddress($order, $dto->billing_address, 'billing');
        }
    }

    /**
     * Update or create address for the order
     */
    private function updateOrCreateAddress(Order $order, $addressDto, string $type): void
    {
        $addressField = "{$type}_address_id";
        $addressId = $order->{$addressField};

        $addressData = $addressDto->toArray();
        $addressData = array_merge($addressData, [
            'organization_id' => $order->organization_id,
            'user_id' => $order->user_id,
        ]);

        if ($addressId) {
            // Update existing address
            Address::query()->where('id', $addressId)->update($addressData);
        } else {
            // Create new address
            $address = Address::query()->create($addressData);
            $order->update([$addressField => $address->id]);
        }
    }
}
