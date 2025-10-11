<?php

namespace App\Modules\Organization\app\DTO\OrganizationSetting;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationSettingDto implements DTOInterface
{
    public ?int $organization_id = null;

    public ?int $employee_id = null;

    public $logo = null;

    public ?string $primary_color = null;

    public ?string $secondary_color = null;

    public ?string $facebook_link = null;

    public ?string $instagram_link = null;

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $address = null;

    public ?string $lat = null;

    public ?string $lng = null;

    public ?string $x_link = null;

    public ?string $tiktok_link = null;

    public function __construct(
        ?int $organization_id = null,
        ?int $employee_id = null,
        $logo = null,
        ?string $primary_color = null,
        ?string $secondary_color = null,
        ?string $facebook_link = null,
        ?string $instagram_link = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $address = null,
        ?string $lat = null,
        ?string $lng = null,
        ?string $x_link = null,
        ?string $tiktok_link = null
    ) {
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->logo = $logo;
        $this->primary_color = $primary_color;
        $this->secondary_color = $secondary_color;
        $this->facebook_link = $facebook_link;
        $this->instagram_link = $instagram_link;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->x_link = $x_link;
        $this->tiktok_link = $tiktok_link;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;

        return new self(
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            logo: $arrayData['logo'] ?? null,
            primary_color: $arrayData['primary_color'] ?? null,
            secondary_color: $arrayData['secondary_color'] ?? null,
            facebook_link: $arrayData['facebook_link'] ?? null,
            instagram_link: $arrayData['instagram_link'] ?? null,
            phone: $arrayData['phone'] ?? null,
            email: $arrayData['email'] ?? null,
            address: $arrayData['address'] ?? null,
            lat: $arrayData['lat'] ?? null,
            lng: $arrayData['lng'] ?? null,
            x_link: $arrayData['x_link'] ?? null,
            tiktok_link: $arrayData['tiktok_link'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'organization_id' => $this->organization_id,
            'employee_id' => $this->employee_id,
            'logo' => $this->logo,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'facebook_link' => $this->facebook_link,
            'instagram_link' => $this->instagram_link,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'x_link' => $this->x_link,
            'tiktok_link' => $this->tiktok_link,
        ];
    }
}
