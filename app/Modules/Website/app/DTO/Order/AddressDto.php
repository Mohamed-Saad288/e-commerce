<?php

namespace App\Modules\Website\app\DTO\Order;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class AddressDto implements DTOInterface
{
    protected ?string $address1 = null;

    protected ?string $address2 = null;

    protected ?int $city_id = null;

    protected ?int $country_id = null;

    protected ?string $postal_code = null;

    protected ?string $phone = null;

    protected ?int $user_id = null;

    protected ?bool $is_default = true;

    protected ?int $type = null;

    protected ?int $organization_id = null;

    public function __construct(?string $address1 = null, ?string $address2 = null, ?int $city_id = null, ?int $country_id = null, ?string $postal_code = null,
        ?string $phone = null, ?int $user_id = null, ?bool $is_default = null, ?int $type = null, ?int $organization_id = null
    ) {
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city_id = $city_id;
        $this->country_id = $country_id;
        $this->postal_code = $postal_code;
        $this->phone = $phone;
        $this->user_id = $user_id;
        $this->is_default = $is_default;
        $this->type = $type;
        $this->organization_id = $organization_id;
    }

    public static function fromArray(FormRequest|array $data): AddressDto
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;

        return new self(
            address1: $arrayData['address1'] ?? null,
            address2: $arrayData['address2'] ?? null,
            city_id: $arrayData['city_id'] ?? null,
            country_id: $arrayData['country_id'] ?? null,
            postal_code: $arrayData['postal_code'] ?? null,
            phone: $arrayData['phone'] ?? null,
            user_id: $arrayData['user_id'] ?? null,
            is_default: $arrayData['is_default'] ?? true,
            type: $arrayData['type'] ?? null,
            organization_id: $arrayData['organization_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'user_id' => $this->user_id,
            'is_default' => $this->is_default,
            'type' => $this->type,
            'organization_id' => $this->organization_id,
        ];
    }
}
