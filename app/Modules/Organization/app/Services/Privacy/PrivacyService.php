<?php

namespace App\Modules\Organization\app\Services\Privacy;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PrivacyService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Header::class));
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
