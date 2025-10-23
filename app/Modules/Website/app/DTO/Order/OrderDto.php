<?php

namespace App\Modules\Website\app\DTO\Order;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\Enums\Address\AddressEnum;
use App\Modules\Organization\Enums\Order\OrderStatusEnum;
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

        // Get order items with calculated prices
        $orderItems = self::getOrderItems($arrayData);

        // Calculate order totals from order items
        $totals = self::calculateOrderTotals($orderItems, $arrayData);

        return new self(
            cart_id: $arrayData['cart_id'] ?? null,
            user_id: auth()->id(),
            shipping_address_id: $arrayData['shipping_address_id'] ?? null,
            payment_method_id: $arrayData['payment_method_id'] ?? null,
            coupon_id: $arrayData['coupon_id'] ?? null,
            notes: $arrayData['notes'] ?? null,
            tracking_number: $arrayData['tracking_number'] ?? null,
            organization_id: auth()->user()->organization_id ?? null,
            status: $arrayData['status'] ?? OrderStatusEnum::PENDING->value,
            total_amount: $totals['total_amount'],
            discount_amount: $totals['discount_amount'],
            tax_amount: $totals['tax_amount'],
            shipping_amount: $totals['shipping_amount'],
            sub_total: $totals['sub_total'],
            shipping_address: self::shippingAddress($arrayData),
            billing_address: self::billingAddress($arrayData),
            orderItems: $orderItems,
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
            //            'totals' => [
            'total_amount' => $this->total_amount,
            'discount_amount' => $this->discount_amount,
            'tax_amount' => $this->tax_amount,
            'shipping_amount' => $this->shipping_amount,
            'sub_total' => $this->sub_total,
            //            ],
            'shipping_address' => $this->shipping_address?->toArray(),
            'billing_address' => $this->billing_address?->toArray(),
            'order_items' => array_map(fn ($item) => $item->toArray(), $this->orderItems),
        ];

    }

    /**
     * Get order items with calculated prices
     */
    private static function getOrderItems(array $data): array
    {
        $productVariations = self::getProducts($data);

        if (empty($productVariations)) {
            return [];
        }

        return array_map(fn ($item) => OrderItemsDto::fromArray($item), $productVariations);
    }

    /**
     * Calculate order totals from order items
     */
    private static function calculateOrderTotals(array $orderItems, array $data): array
    {
        $subTotal = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        $shippingAmount = 0;

        // Calculate totals from order items
        foreach ($orderItems as $item) {
            $subTotal += $item->sub_total ?? 0;
            $totalDiscount += $item->discount_amount ?? 0;
            $totalTax += $item->tax_amount ?? 0;
        }

        // Get shipping amount from data or calculate it
        $shippingAmount = $data['shipping_amount'] ?? 0;

        // Apply coupon discount if provided
        if (! empty($data['coupon_id'])) {
            // You can add coupon calculation logic here
            // $couponDiscount = self::calculateCouponDiscount($data['coupon_id'], $subTotal);
            // $totalDiscount += $couponDiscount;
        }

        $totalAmount = $subTotal - $totalDiscount + $totalTax + $shippingAmount;

        return [
            'sub_total' => $subTotal,
            'discount_amount' => $totalDiscount,
            'tax_amount' => $totalTax,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * Fetch products array either from the request or from the cart.
     */
    private static function getProducts(array $data): array
    {
        if (! empty($data['cart_id']) && empty($data['product_variations'])) {
            // Fetch items from Cart if products are not passed directly
            // You would implement cart item fetching logic here
            // return CartService::getCartItems($data['cart_id']);
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
                'user_id' => auth()->id(),
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
                    'user_id' => auth()->id(),
                ]);
            }

            return new AddressDto;
        }

        if (isset($data['billing_address'])) {
            return AddressDto::fromArray([
                ...$data['billing_address'],
                'type' => AddressEnum::BILLING->value,
                'user_id' => auth()->id(),
            ]);
        }

        return new AddressDto;
    }
}
