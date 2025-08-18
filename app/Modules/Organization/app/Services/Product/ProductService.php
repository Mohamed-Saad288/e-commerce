<?php

namespace App\Modules\Organization\app\Services\Product;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Product\Product;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Product::class));
    }

    /**
     * @throws \Throwable
     */
    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $product = parent::store($dto);

            foreach ($dto->toArray()['variations'] as $variation) {
                $variation = $variation->toArray();
                $product_variation = $product->variations()->create($variation);
                $product_variation->option_items()->syncWithPivotValues(
                    $variation['option_items'],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            return $product;
        });
    }


    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto, $model) {
            $model = parent::update(model: $model, dto: $dto);

            $updatedVariationIds = [];

            foreach ($dto->variations as $variationDto) {
                $variationData = $variationDto->toArray();
                $oldVariation = $model->variations()->find($variationDto->id);

                if ($oldVariation) {
                    $oldVariation->update($variationData);
                    $productVariation = $oldVariation;
                } else {
                    $productVariation = $model->variations()->create($variationData);
                }

                $updatedVariationIds[] = $productVariation->id;

                $syncData = [];
                foreach ($variationDto->option_items as $itemId) {
                    $syncData[$itemId] = [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                $productVariation->option_items()->sync($syncData);
            }

            $model->variations()->whereNotIn('id', $updatedVariationIds)->delete();

            return $model;
        });
    }
}
