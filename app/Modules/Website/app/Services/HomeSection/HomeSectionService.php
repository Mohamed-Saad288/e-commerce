<?php

namespace App\Modules\Website\app\Services\HomeSection;

use App\Modules\Admin\app\Models\HomeSection\HomeSection;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Website\app\Http\Resources\HomeSection\HomeSectionProductResource;
use App\Modules\Website\app\Http\Resources\HomeSection\HomeSectionResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;
use Carbon\Carbon;

class HomeSectionService
{
    use WebsiteLinkTrait;

    public function fetch_home_sections()
    {
        $organization = $this->getOrganization();
        $now = Carbon::now();
        $home_sections = HomeSection::query()
            ->where('organization_id', $organization->id)
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now);
                })
                    ->orWhereNull('start_date')
                    ->orWhereNull('end_date');
            })
            ->orderBy('sort_order', 'asc')
            ->get();

        return new DataSuccess(
            data: HomeSectionResource::collection($home_sections),
            status: true,
            message: 'Home Section Fetched Successfully'
        );
    }

    public function fetch_sections_products($data)
    {
        $organization = $this->getOrganization();

        $home_section = HomeSection::where('id', $data['home_section_id'])
            ->where('organization_id', $organization->id)
            ->first();

        $productsQuery = $home_section->products()->latest();

        if (! empty($data['with_pagination']) && $data['with_pagination'] == 1) {
            $perPage = $data['per_page'] ?? 10;

            $paginated = $productsQuery->paginate($perPage);

            $resource = HomeSectionProductResource::collection($paginated)->response()->getData(true);
        } else {
            $products = $productsQuery->get();

            $resource = HomeSectionProductResource::collection($products);
        }

        return new DataSuccess(
            data: $resource,
            status: true,
            message: 'Home Section Fetched Successfully'
        );
    }
}
