<?php

namespace App\Modules\Organization\app\DTO\Employee;

use App\Modules\Base\app\DTO\DTOInterface;

class EmployeeDto implements DTOInterface
{
    public ?string $name;

    public ?string $phone;

    public ?string $email;

    public ?string $password;

    public ?bool $is_master;

    public ?int $organization_id;

    public function __construct(
        ?string $name = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $password = null,
        ?bool $is_master = null,
        ?int $organization_id = null
    ) {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->is_master = $is_master;
        $this->organization_id = $organization_id;
    }

    public static function fromArray($data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null,
            $data['is_master'] ?? 0,
            $data['organization_id'] ?? auth()->user()->organization_id
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password,
            'is_master' => $this->is_master,
            'organization_id' => $this->organization_id,
        ];
    }
}
