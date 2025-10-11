<?php

namespace App\Modules\Organization\app\Services\Product;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Product::class));
    }

    /**
     * Store product with variations
     */
    public function store(DtoInterface $dto): Model
    {
        try {
            return DB::transaction(function () use ($dto) {
                $product = parent::store($dto);

                foreach ($dto->toArray()['variations'] as $variation) {
                    $variation = $variation->toArray();

                    $productVariation = $product->variations()->create($variation);

                    $productVariation->storeImages(media: $variation['main_images']);
                    $productVariation->storeImages(media: $variation['additional_images']);

                    $productVariation->option_items()->syncWithPivotValues(
                        $variation['option_items'],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }

                return $product;
            });
        } catch (Throwable $e) {
            Log::error('Error while storing product', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'dto' => $dto->toArray(),
            ]);
            throw $e; // rethrow so it can be handled by exception handler
        }
    }

    /**
     * Update product with variations
     */
    public function update(Model $model, DtoInterface $dto): Model
    {
        try {
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
        } catch (Throwable $e) {
            Log::error('Error while updating product', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'model_id' => $model->id,
                'dto' => $dto->toArray(),
            ]);
            throw $e;
        }
    }
}
