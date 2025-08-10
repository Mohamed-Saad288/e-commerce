<?php

namespace App\Modules\Admin\app\DTO\Plans;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class FeatureDto implements DTOInterface
{
    public ?string $name = null;
    public ?string $description = null;
    public ?bool $is_active = null;
    public ?string $slug = null;
    public ?int $type = null;
    public ?int $added_by_id = null;
    public function __construct(
        ?string $name = null,
        ?string $description = null,
        ?bool $is_active = null,
        ?string $slug = null,
        ?int $type = null,
        ?int $added_by_id = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->is_active = $is_active;
        $this->slug = $slug;
        $this->type = $type;
        $this->added_by_id = $added_by_id;
    }


    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $added_by_id = auth()->user()->id;
        return new self(
            name: $data->name ?? null,
            description: $data->description ?? null,
            is_active: $data->is_active ?? null,
            slug: $data->slug ?? null,
            type: $data->type ?? null,
            added_by_id: $added_by_id ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'slug' => $this->slug,
            'type' => $this->type,
            'added_by_id' => $this->added_by_id,
        ];
    }
}
