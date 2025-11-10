<?php

namespace App\Modules\Organization\app\DTO\Product\v2;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Organization\app\Builder\Product\ProductBuilder;
use App\Modules\Organization\app\Enum\ProductTypeEnum;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductDto implements DTOInterface
{
    public function __construct(
        public ?array $translations = [],
        public ?int $brand_id = null,
        public ?int $category_id = null,
        public ?int $organization_id = null,
        public ?int $employee_id = null,
        public ?string $slug = null,
        public ?int $type = null,
        public ?int $low_stock_threshold = null,
        public ?bool $requires_shipping = true,
        public ?int $stock_quantity = 0,
        public ?array $variations = [],
    ) {}

    public static function fromArray(FormRequest|array $data): DTOInterface
    {
       return (new ProductBuilder())
           ->setData($data)
           ->setTranslation()
           ->setDefaultVariation()
           ->setVariationTranslation()
           ->setVariations()
           ->build();
    }

    public function toArray(): array
    {
        return array_merge(
            $this->translations,
            [
                'brand_id' => $this->brand_id,
                'category_id' => $this->category_id,
                'organization_id' => $this->organization_id,
                'employee_id' => $this->employee_id,
                'slug' => $this->slug,
                'type' => $this->type,
                'low_stock_threshold' => $this->low_stock_threshold,
                'requires_shipping' => $this->requires_shipping,
                //                'variations' => array_map(fn($variant) => $variant->toArray(), $this->variations ?? []),
                'variations' => $this->variations,
            ]
        );
    }

}
