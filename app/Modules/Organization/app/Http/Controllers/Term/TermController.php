<?php

namespace App\Modules\Organization\app\Http\Controllers\Term;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Term\TermDto;
use App\Modules\Organization\app\Http\Request\Term\StoreTermRequest;
use App\Modules\Organization\app\Http\Request\Term\UpdateTermRequest;
use App\Modules\Organization\app\Models\Term\Term;
use App\Modules\Organization\app\Services\Term\TermService;
use Exception;

class TermController extends Controller
{
    public function __construct(protected TermService $service) {}

    public function index()
    {
        $terms = $this->service->index();

        return view('organization::dashboard.terms.index', get_defined_vars());
    }

    public function create()
    {
        return view('organization::dashboard.terms.single', get_defined_vars());
    }

    public function store(StoreTermRequest $request)
    {
        $this->service->store(TermDto::fromArray($request));

        return to_route('organization.terms.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Term $term)
    {
        $terms = Term::where('organization_id',auth()->user()->organization_id)->first();
        return view('organization::dashboard.terms.single', get_defined_vars());
    }

    public function update(UpdateTermRequest $request, Term $term)
    {
        $terms = Term::firstOrCreate(
            ['organization_id' => auth()->user()->organization_id],
            ['organization_id' => auth()->user()->organization_id] // قيم افتراضية
        );

        return to_route('organization.terms.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(Term $term)
    {
        try {
            $this->service->delete(model: $term);

            return response()->json([
                'success' => true,
                'message' => __('messages.deleted'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong'),
            ], 500);
        }
        $this->service->update(model: $terms, dto: TermDto::fromArray($request->validated()));

        return to_route('organization.terms.edit')->with([
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ]);
    }
}
