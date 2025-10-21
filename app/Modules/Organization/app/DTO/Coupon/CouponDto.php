<?php

namespace App\Modules\Organization\app\DTO\Coupon;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class CouponDto implements DTOInterface
{
    public ?int $organization_id = null;

    public ?string $code = null;

    public ?string $type = null;

    public ?float $value = null;

    public ?float $min_order_amount = null;

    public ?string $start_date = null;

    public ?string $end_date = null;

    public ?int $usage_limit = null;

    public ?int $used_count = null;

    public bool $is_active = true;

    public function __construct(
        ?int $organization_id = null,
        ?string $code = null,
        ?string $type = null,
        ?float $value = null,
        ?float $min_order_amount = null,
        ?string $start_date = null,
        ?string $end_date = null,
        ?int $usage_limit = null,
        ?int $used_count = null,
        bool $is_active = true
    ) {
        $this->organization_id = $organization_id;
        $this->code = $code;
        $this->type = $type;
        $this->value = $value;
        $this->min_order_amount = $min_order_amount;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->usage_limit = $usage_limit;
        $this->used_count = $used_count;
        $this->is_active = $is_active;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $organizationId = auth('organization_employee')->user()->organization_id ?? null;

        return new self(
            organization_id: $organizationId,
            code: $arrayData['code'] ?? null,
            type: $arrayData['type'] ?? null,
            value: $arrayData['value'] ?? null,
            min_order_amount: $arrayData['min_order_amount'] ?? null,
            start_date: $arrayData['start_date'] ?? null,
            end_date: $arrayData['end_date'] ?? null,
            usage_limit: $arrayData['usage_limit'] ?? null,
            used_count: $arrayData['used_count'] ?? 0,
            is_active: $arrayData['is_active'] ?? true,
        );
    }

    public function toArray(): array
    {
        return [
            'organization_id' => $this->organization_id,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'min_order_amount' => $this->min_order_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'usage_limit' => $this->usage_limit,
            'used_count' => $this->used_count,
            'is_active' => $this->is_active,
        ];
    }
}
