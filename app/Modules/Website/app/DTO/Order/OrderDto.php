<?php

namespace App\Modules\Website\app\DTO\Order;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\Enums\Address\AddressEnum;
use Illuminate\Foundation\Http\FormRequest;

class OrderDto implements DTOInterface
{
    public function __construct(
        public ?int $cart_id = null,
        public ?int $user_id = null,
        public ?int $shipping_address_id = null,
        public ?int $payment_method_id = null,
        public ?int $coupon_id = null,
        public ?string $notes = null,
        public ?string $tracking_number = null,
        public ?int $organization_id = null,
        public ?int $status = null,
        public ?float $total_amount = null,
        public ?float $discount_amount = null,
        public ?float $tax_amount = null,
        public ?float $shipping_amount = null,
        public ?float $sub_total = null,
        public ?AddressDto $shipping_address = null,
        public ?AddressDto $billing_address = null,
        public array $orderItems = [],
        public ?string $order_number = null,
    ) {}

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $arrayData['product_variations'] = self::getProducts($arrayData);

        return new self(
            cart_id: $arrayData['cart_id'] ?? null,
            user_id: auth()->id(),
            shipping_address_id: $arrayData['shipping_address_id'] ?? null,
            payment_method_id: $arrayData['payment_method_id'] ?? null,
            coupon_id: $arrayData['coupon_id'] ?? null,
            notes: $arrayData['notes'] ?? null,
            tracking_number: $arrayData['tracking_number'] ?? null,
            organization_id: auth()->user()->organization_id ?? null,
            status: $arrayData['status'] ?? null,
            total_amount: $arrayData['total_amount'] ?? null,
            discount_amount: $arrayData['discount_amount'] ?? null,
            tax_amount: $arrayData['tax_amount'] ?? null,
            shipping_amount: $arrayData['shipping_amount'] ?? null,
            sub_total: $arrayData['sub_total'] ?? null,
            shipping_address: self::shippingAddress($arrayData),
            billing_address: self::billingAddress($arrayData),
            orderItems: isset($arrayData['product_variations'])
                ? array_map(fn ($item) => OrderItemsDto::fromArray($item), $arrayData['product_variations'])
                : [],
            order_number: 'ORD-'.now()->format('Ymd').'-'.random_int(1000, 9999),
        );
    }

    public function toArray(): array
    {
        return [
            'cart_id' => $this->cart_id,
            'user_id' => $this->user_id,
            'organization_id' => $this->organization_id,
            'payment_method_id' => $this->payment_method_id,
            'coupon_id' => $this->coupon_id,
            'status' => $this->status,
            'tracking_number' => $this->tracking_number,
            'notes' => $this->notes,
            'totals' => [
                'total' => $this->total_amount,
                'discount' => $this->discount_amount,
                'tax' => $this->tax_amount,
                'shipping' => $this->shipping_amount,
                'sub_total' => $this->sub_total,
            ],
            'shipping_address' => $this->shipping_address?->toArray(),
            'billing_address' => $this->billing_address?->toArray(),
            'order_items' => array_map(fn ($item) => $item->toArray(), $this->orderItems),
        ];
    }

    /**
     * Fetch products array either from the request or from the cart.
     */
    private static function getProducts(array $data): array
    {
        if (! empty($data['cart_id']) && empty($data['product_variations'])) {
            // Fetch items from Cart if products are not passed directly
        }

        return $data['product_variations'] ?? [];
    }

    /**
     * Handle shipping address creation.
     */
    private static function shippingAddress(array $data): AddressDto
    {
        if (isset($data['shipping_address'])) {
            return AddressDto::fromArray([
                ...$data['shipping_address'],
                'type' => AddressEnum::SHIPPING->value,
                'user_id' => $data['user_id'],
            ]);
        }

        return new AddressDto;
    }

    /**
     * Handle billing address creation, supports "same as shipping".
     */
    private static function billingAddress(array $data): AddressDto
    {
        if (! empty($data['billing_same_as_shipping']) && $data['billing_same_as_shipping']) {
            if (isset($data['shipping_address'])) {
                return AddressDto::fromArray([
                    ...$data['shipping_address'],
                    'type' => AddressEnum::BILLING->value,
                    'user_id' => $data['user_id'],
                ]);
            }

            return new AddressDto;
        }

        return new AddressDto;
    }
}
