<?php

namespace App\Modules\Admin\app\DTO\Plans;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class PlanDto implements DTOInterface
{
    public ?array $translations = [];
    public ?bool $is_active = null;
    public ?string $slug = null;
    public ?int $billing_type = null;
    public ?int $added_by_id = null;
    public ?int $duration = null;
    public ?int $price = null;
    public ?int $trial_period = null;
    public ?int $sort_order = null;
    public ?array $features = [];
    public ?string $image = null;

    public function __construct(
        ?array $translations = [],
        ?bool $is_active = null,
        ?string $slug = null,
        ?int $billing_type = null,
        ?int $added_by_id = null,
        ?int $duration = null,
        ?int $price = null,
        ?int $trial_period = null,
        ?int $sort_order = null,
        ?array $features = [],
        ?string $image = null
    ) {
        $this->translations = $translations;
        $this->is_active = $is_active;
        $this->slug = $slug;
        $this->billing_type = $billing_type;
        $this->added_by_id = $added_by_id;
        $this->duration = $duration;
        $this->price = $price;
        $this->trial_period = $trial_period;
        $this->sort_order = $sort_order;
        $this->features = $features;
        $this->image = $image;
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
        $features = [];
        if (isset($arrayData['features'])) {
            foreach ($arrayData['features'] as $feature) {
                $features[] = [
                    'feature_id' => $feature['feature_id'],
                    'feature_value'      => $feature['value']
                ];
            }
        }
        return new self(
            translations: $translations,
            is_active: $arrayData['is_active'] ?? null,
            slug: $arrayData['slug'] ?? null,
            billing_type: $arrayData['billing_type'] ?? null,
            added_by_id: auth()->id(),
            duration: $arrayData['duration'] ?? null,
            price: $arrayData['price'] ?? null,
            trial_period: $arrayData['trial_period'] ?? null,
            sort_order: $arrayData['sort_order'] ?? null,
            features: $features,
            image: $data->image ?? null
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'is_active'    => $this->is_active,
                'slug'         => $this->slug,
                'billing_type'         => $this->billing_type,
                'added_by_id'  => $this->added_by_id,
                "duration"     => $this->duration,
                "price"        => $this->price,
                "trial_period" => $this->trial_period,
                "sort_order"   => $this->sort_order,
                "features"     => $this->features,
                "image"        => $this->image
            ]
        );
    }
}
