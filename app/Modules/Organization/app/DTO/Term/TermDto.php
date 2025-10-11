<?php

namespace App\Modules\Organization\app\DTO\Term;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class TermDto implements DTOInterface
{
    public ?array $translations = [];

    public ?int $organization_id = null;

    public ?int $employee_id = null;

    public function __construct(
        ?array $translations = [],
        ?int $organization_id = null,
        ?int $employee_id = null,
    ) {
        $this->translations = $translations;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
    }

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
        $arrayData = $data instanceof FormRequest ? $data->validated() : $data;
        $translations = [];
        foreach (config('translatable.locales') as $locale) {
            $translations[$locale] = [
                'description' => $arrayData[$locale]['description'] ?? null,
            ];
        }

        return new self(
            translations: $translations,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'organization_id' => $this->organization_id,
                'employee_id' => $this->employee_id,
            ]
        );
    }
}
