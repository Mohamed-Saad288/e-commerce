<?php

namespace App\Modules\Organization\app\DTO\OptionItem;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class OptionItemDto implements DTOInterface
{
    public ?array $translations = [];
    public ?int $organization_id = null;
    public ?int $employee_id = null;
    public ?int $option_id = null;
    public function __construct(
        ?array $translations = [],
        ?int $organization_id = null,
        ?int $employee_id = null,
        ?int $option_id = null
    ) {
        $this->translations = $translations;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
        $this->option_id = $option_id;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'name'        => $arrayData[$locale]['name'] ?? null,
            ];
        }

        return new self(
            translations: $translations,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            option_id: $arrayData['option_id']
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'organization_id'         => $this->organization_id,
                'employee_id'  => $this->employee_id,
                'option_id' => $this->option_id
            ]
        );
    }
}
