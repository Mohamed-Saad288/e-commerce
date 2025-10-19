<?php

namespace App\Modules\Admin\app\DTO\Admin;

use App\Modules\Base\app\DTO\DTOInterface;

class AdminDto implements DTOInterface
{
    public ?string $name;
    public ?string $phone;

    public ?string $email;

    public ?string $password;

    public function __construct(
        ?string $name = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $password = null
    ) {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray($data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
