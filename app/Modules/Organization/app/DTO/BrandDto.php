<?php

namespace App\Modules\Organization\app\DTO;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class BrandDto implements DTOInterface
{
    public ?array $translations = [];
    public ?bool $is_active = null;
    public ?string $slug = null;
    public ?int $organization_id = null;
    public ?int $employee_id = null;
    public array $categories = [];
    public function __construct(
        ?array $translations = [],
        ?bool $is_active = null,
        ?string $slug = null,
        ?int $organization_id = null,
        ?int $employee_id = null,
        ?array $categories = []
    ) {
        $this->translations = $translations;
        $this->is_active = $is_active;
        $this->slug = $slug;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->categories = $categories;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name'        => $arrayData[$locale]['name'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
            ];
        }

        return new self(
            translations: $translations,
            is_active: $arrayData['is_active'] ?? null,
            slug: $arrayData['slug'] ?? null,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->id(),
            categories: $arrayData['categories']
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'is_active'    => $this->is_active,
                'slug'         => $this->slug,
                'organization_id'         => $this->organization_id,
                'employee_id'  => $this->employee_id,
                'categories'   => $this->categories
            ]
        );
    }
}
