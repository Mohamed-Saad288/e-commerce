<?php

namespace App\Modules\Organization\app\DTO\OurTeam;

use App\Modules\Base\app\DTO\DTOInterface;

class OurTeamDto implements DTOInterface
{
    public ?string $name;
    public ?string $facebook_link;
    public ?string $instagram_link;
    public ?string $tiktok_link;
    public ?string $x_link;
    public $image;
    public ?int $organization_id;

    public function __construct(
        ?string $name = null,
        ?string $facebook_link = null,
        ?string $instagram_link = null,
        ?string $tiktok_link = null,
        ?string $x_link = null,
        ?int $organization_id = null,
        $image = null
    ) {
        $this->name = $name;
        $this->facebook_link = $facebook_link;
        $this->instagram_link = $instagram_link;
        $this->tiktok_link = $tiktok_link;
        $this->x_link = $x_link ;
        $this->organization_id = $organization_id;
        $this->image = $image;
    }

    public static function fromArray($data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['facebook_link'] ?? null,
            $data['instagram_link'] ?? null,
            $data['tiktok_link'] ?? null,
            $data['x_link'] ?? 0,
            $data['organization_id'] ?? auth()->user()->organization_id,
            $data['image'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name'     => $this->name,
            'facebook_link'    => $this->facebook_link,
            'instagram_link'    => $this->instagram_link,
            'tiktok_link' => $this->tiktok_link,
            'x_link' => $this->x_link,
            "organization_id" => $this->organization_id,
            'image' => $this->image
        ];
    }
}
