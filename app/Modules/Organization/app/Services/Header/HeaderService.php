<?php

namespace App\Modules\Organization\app\Services\Header;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Header\Header;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeaderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(Header::class));
    }

    public function store(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();
            if (! empty($dto->image)) {

                $data['image'] = uploadImage($dto->image, 'header');

            }
            $model = $this->model->query()->create($data);

            if (! empty($dto->image)) {

            }

            return $model;
        });

    }

    public function update(Model $model, DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($model, $dto) {
            $data = $dto->toArray();

            if (! empty($dto->images)) {
                foreach ($model->images as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage->image)) {
                        Storage::disk('public')->delete($oldImage->image);
                    }
                    $oldImage->delete();
                }

                foreach ($dto->images as $image) {
                    $path = uploadImage($image, 'headers');
                    $model->images()->create([
                        'image' => $path,
                    ]);
                }
            }

            $model->update($data);

            return $model;
        });
    }
    //    public function update(Model $model, DtoInterface $dto): Model
    //    {
    //        return DB::transaction(function () use ($model, $dto) {
    //            $data = $dto->toArray();
    //
    //            if (! empty($dto->images)) {
    //                foreach ($model->images as $oldImage) {
    //                    if (Storage::disk('public')->exists($oldImage->image)) {
    //                        Storage::disk('public')->delete($oldImage->image);
    //                    }
    //                    $oldImage->delete();
    //                }
    //
    //                foreach ($dto->images as $image) {
    //                    $path = uploadImage($image, 'headers');
    //                    $model->images()->create([
    //                        'image' => $path,
    //                    ]);
    //                }
    //            }
    //
    //            $model->update($data);
    //
    //            return $model;
    //        });
    //    }
}
