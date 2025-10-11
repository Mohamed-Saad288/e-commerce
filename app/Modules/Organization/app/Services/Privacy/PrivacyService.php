<?php

namespace App\Modules\Organization\app\Services\Privacy;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Privacy\Privacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrivacyService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Privacy::class));
    }

    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();
            $model->update($data);

            return $model;
        });
    }
}
