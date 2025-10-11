<?php

namespace App\Modules\Organization\app\Http\Controllers\Privacy;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Privacy\PrivacyDto;
use App\Modules\Organization\app\Http\Request\Privacy\StorePrivacyRequest;
use App\Modules\Organization\app\Models\Privacy\Privacy;
use App\Modules\Organization\app\Services\Privacy\PrivacyService;
use Exception;
use Illuminate\Support\Facades\Storage;

class PrivacyController extends Controller
{
    public function __construct(protected PrivacyService $service){}


    public function edit()
    {
        $privacy = Privacy::where('organization_id',auth()->user()->organization_id)->first();
        return view('organization::dashboard.privacy.single', get_defined_vars());
    }
    public function update(StorePrivacyRequest $request)
    {
        $privacy = Privacy::firstOrCreate(
            ['organization_id' => auth()->user()->organization_id],
            ['organization_id' => auth()->user()->organization_id] // قيم افتراضية
        );

        $this->service->update(model: $privacy, dto: PrivacyDto::fromArray($request->validated()));

        return to_route('organization.privacy.edit')->with([
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ]);
    }



}
