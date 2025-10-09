<?php

namespace App\Modules\Organization\app\Http\Controllers\Term;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Term\TermDto;
use App\Modules\Organization\app\Http\Request\Term\StoreTermRequest;
use App\Modules\Organization\app\Http\Request\Term\UpdateTermRequest;
use App\Modules\Organization\app\Models\Term\Term;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Services\Term\TermService;
use Exception;

class TermController extends Controller
{
    public function __construct(protected TermService $service){}

    public function edit()
    {
        $terms = Term::where('organization_id',auth()->user()->organization_id)->first();
        return view('organization::dashboard.terms.single', get_defined_vars());
    }
    public function update(StoreTermRequest $request)
    {
        $terms = Term::firstOrCreate(
            ['organization_id' => auth()->user()->organization_id],
            ['organization_id' => auth()->user()->organization_id] // قيم افتراضية
        );

        $this->service->update(model: $terms, dto: TermDto::fromArray($request->validated()));

        return to_route('organization.terms.edit')->with([
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ]);
    }


}
