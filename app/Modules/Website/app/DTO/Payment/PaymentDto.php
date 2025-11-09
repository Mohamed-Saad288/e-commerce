<?php

namespace App\Modules\Website\app\DTO\Payment;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\app\Models\Order\Order;
use App\Modules\Website\app\Enums\Payment\PaymentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class PaymentDto implements DTOInterface
{
    public function __construct(protected ?int $order_id=null , protected ?int $payment_method_id=null , public ?UploadedFile $image=null , protected ?float $amount=null , protected ?int $organization_id=null,
    protected ?string $transaction_id = null , protected ?int $status = null , protected ?string $currency = null , protected ?array $meta = null)
    {
    }
    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $data = $data instanceof FormRequest ? $data->validated() : $data;
        return new self(
            order_id: $data['order_id'] ?? null,
            payment_method_id: $data['payment_method_id'] ?? null,
            image: $data['receipt'] ?? null,
            amount: self::getAmount(order_id: $data["order_id"]),
            organization_id: $data['organization_id'] ?? auth()->user()->organization_id,
            transaction_id: $data['transaction_id'] ?? null,
            status: $data['status'] ?? PaymentStatusEnum::PENDING->value,
            currency: $data['currency'] ?? "EGP",
            meta: $data['meta'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'order_id' => $this->order_id,
            'payment_method_id' => $this->payment_method_id,
            'image' => $this->image,
            'amount' => $this->amount,
            'organization_id' => $this->organization_id,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'currency' => $this->currency,
            'meta' => $this->meta,
        ];
    }

    private static function getAmount($order_id)
    {
        return Order::find($order_id)->total_amount;
    }
}
