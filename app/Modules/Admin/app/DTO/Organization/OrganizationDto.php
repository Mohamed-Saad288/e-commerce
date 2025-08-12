<?php

namespace App\Modules\Admin\app\DTO\Organization;

use App\Modules\Base\app\DTO\DTOInterface;

class OrganizationDto implements DTOInterface
{
    public ?string $name;
    public ?string $phone;
    public ?string $email;
    public ?string $address;
    public ?string $website_link;

    public function __construct(
        ?string $name = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $address = null,
        ?string $website_link = null
    ) {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->website_link = $website_link;
    }

    public static function fromArray($data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['address'] ?? null,
            $data['website_link'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name'     => $this->name,
            'phone'    => $this->phone,
            'email'    => $this->email,
            'address' => $this->address,
            'website_link' => $this->website_link
        ];
    }
}
