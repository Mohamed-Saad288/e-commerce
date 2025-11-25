<?php

namespace App\Modules\Organization\app\DTO\HomeSection;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class HomeSectionDto implements DTOInterface
{
    public ?array $translations = [];

    public ?int $organization_id = null;

    public ?int $employee_id = null;

    public $start_date;

    public $end_date;

    public $products;

    public $type;

    public $sort_order;

    public $template_type;

    public function __construct(
        ?array $translations = [],
        ?int $organization_id = null,
        ?int $employee_id = null,
        $products = null,
        $type = null,
        $sort_order = null,
        $start_date = null,
        $end_date = null,
        $template_type = null
    ) {
        $this->translations = $translations;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->products = $products;
        $this->type = $type;
        $this->sort_order = $sort_order;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->template_type = $template_type;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'title' => $arrayData[$locale]['title'] ?? null,
                'description' => $arrayData[$locale]['description'] ?? null,
            ];
        }

        return new self(
            translations: $translations,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            products: $arrayData['products'] ?? null,
            type: $arrayData['type'] ?? null,
            sort_order: $arrayData['sort_order'] ?? null,
            start_date: $arrayData['start_date'] ?? null,
            end_date: $arrayData['end_date'] ?? null,
            template_type: $arrayData['template_type'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'organization_id' => $this->organization_id,
                'employee_id' => $this->employee_id,
                'products' => $this->products,
                'type' => $this->type,
                'sort_order' => $this->sort_order,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'template_type' => $this->template_type,
            ]
        );
    }
}
