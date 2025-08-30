<?php

namespace App\Modules\Organization\app\Services\OrganizationSetting;

use App\Modules\Base\app\DTO\DTOInterface;
use App\Modules\Base\app\Services\BaseService;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Organization\app\Models\OrganizationSetting\OrganizationSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrganizationSettingService extends BaseService
{
    public function __construct()
    {
        parent::__construct(resolve(OrganizationSetting::class));
    }
    public function updateOrCreateByOrganization(DtoInterface $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();

            if (!empty($dto->logo)) {
                if (!empty($dto->organization_id)) {
                    $existing = $this->model->where('organization_id', $dto->organization_id)->first();

                    if ($existing && $existing->logo && Storage::disk('public')->exists($existing->logo)) {
                        Storage::disk('public')->delete($existing->logo);
                    }
                }

                $data['logo'] = uploadImage($dto->logo, 'settings');
            }

            return $this->model->updateOrCreate(
                ['organization_id' => $dto->organization_id],
                $data
            );
        });
    }
}
