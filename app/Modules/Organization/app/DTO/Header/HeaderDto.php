<?php

namespace App\Modules\Organization\app\DTO\Header;

use App\Modules\Base\app\DTO\DTOInterface;
use Illuminate\Foundation\Http\FormRequest;

class HeaderDto implements DTOInterface
{
    public ?array $translations = [];
    public ?int $organization_id = null;
    public ?int $employee_id = null;
    public  $image;
    public function __construct(
        ?array $translations = [],
        ?int $organization_id = null,
        ?int $employee_id = null,
        $image = null
    ) {
        $this->translations = $translations;
        $this->organization_id = $organization_id;
        $this->employee_id = $employee_id;
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

        return new self(
            translations: $translations,
            organization_id: auth()->user()->organization_id ?? null,
            employee_id: auth()->user()->id,
            image: $arrayData['image'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'organization_id'         => $this->organization_id,
                'employee_id'  => $this->employee_id,
                'image' => $this->image
            ]
        );
    }
}
