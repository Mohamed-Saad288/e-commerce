<?php

namespace App\Modules\Organization\app\Services\HomeSection;

use App\Modules\Admin\app\Models\HomeSection\HomeSection;
use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeSectionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(HomeSection::class));
    }

    /**
     * @throws \Throwable
     */
    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $lastOrder = $this->model->query()
                ->where('organization_id', $dto->organization_id)
                ->max('sort_order');

            $nextOrder = $lastOrder ? $lastOrder + 1 : 1;

            $data = array_merge($dto->toArray(), [
                'sort_order' => $nextOrder,
            ]);

            $home_section = $this->model->query()->create($data);

            if (! empty($dto->products)) {
                $home_section->productVariations()->attach($dto->products);
            }
            $this->reorderOrganizationSections($dto->organization_id);

            return $home_section;
        });
    }

    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto, $model) {

            $data = $dto->toArray();

            if (isset($data['sort_order'])) {
                $newOrder = $data['sort_order'];

                if ($newOrder != $model->sort_order) {
                    $this->model->query()
                        ->where('organization_id', $dto->organization_id)
                        ->where('id', '!=', $model->id)
                        ->where('sort_order', '>=', $newOrder)
                        ->increment('sort_order');
                }
            }

            $model->update($data);

            if (! empty($dto->products)) {
                $this->reorderOrganizationSections($dto->organization_id);
            }

            if (! empty($dto->products)) {
                $model->productVariations()->sync($dto->products);
            }

            return $model;
        });
    }

    protected function reorderOrganizationSections($organizationId): void
    {
        $sections = $this->model->query()
            ->where('organization_id', $organizationId)
            ->orderBy('sort_order')
            ->get();

        $counter = 1;
        foreach ($sections as $section) {
            $section->updateQuietly(['sort_order' => $counter++]);
        }
    }
}
