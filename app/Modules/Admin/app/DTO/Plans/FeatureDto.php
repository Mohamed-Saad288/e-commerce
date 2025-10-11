<?php

namespace App\Modules\Admin\app\DTO\Plans;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class FeatureDto implements DTOInterface
{
    public ?array $translations = [];

    public ?bool $is_active = null;

    public ?string $slug = null;

    public ?int $type = null;

    public ?int $added_by_id = null;

    public function __construct(
        ?array $translations = [],
        ?bool $is_active = null,
        ?string $slug = null,
        ?int $type = null,
        ?int $added_by_id = null
    ) {
        $this->translations = $translations;
        $this->is_active = $is_active;
        $this->slug = $slug;
        $this->type = $type;
        $this->added_by_id = $added_by_id;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name' => $arrayData[$locale]['name'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
            ];
        }

        return new self(
            translations: $translations,
            is_active: $arrayData['is_active'] ?? null,
            slug: $arrayData['slug'] ?? null,
            type: $arrayData['type'] ?? null,
            added_by_id: auth()->id()
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'is_active' => $this->is_active,
                'slug' => $this->slug,
                'type' => $this->type,
                'added_by_id' => $this->added_by_id,
            ]
        );
    }
}
