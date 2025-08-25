<?php

namespace App\Modules\Organization\app\Services\OurTeam;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Organization\app\Models\OurTeam\OurTeam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OurTeamService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(OurTeam::class));
    }
    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();
            if (!empty($dto->image)) {

                $data['image'] = uploadImage($dto->image, 'our_team');

            }
            $model = $this->model->query()->create($data);

            return $model;
        });

    }
    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();

            if (!empty($dto->image)) {
                if ($model->image && Storage::disk('public')->exists($model->image)) {
                    Storage::disk('public')->delete($model->image);
                }

                $data['image'] = uploadImage($dto->image, 'our_team');
            }

            $model->update($data);

            return $model;
        });
    }
    }
