<?php

namespace App\Modules\Organization\app\Http\Controllers\About;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\About\AboutDto;
use App\Modules\Organization\app\Http\Request\About\StoreAboutRequest;
use App\Modules\Organization\app\Http\Request\About\UpdateAboutRequest;
use App\Modules\Organization\app\Models\About\About;
use App\Modules\Organization\app\Services\About\AboutService;
use Exception;

class AboutController extends Controller
{
    public function __construct(protected AboutService $service)
    {
    }

    public function index()
    {
        $abouts = $this->service->index();

        return view('organization::dashboard.abouts.index', get_defined_vars());
    }

    public function create()
    {
        return view('organization::dashboard.abouts.single', get_defined_vars());
    }

    public function store(StoreAboutRequest $request)
    {
        $this->service->store(AboutDto::fromArray($request));

        return to_route('organization.abouts.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(About $about)
    {
        return view('organization::dashboard.abouts.single', get_defined_vars());
    }

    public function update(UpdateAboutRequest $request, About $about)
    {
        $this->service->update(model: $about, dto: AboutDto::fromArray($request));

        return to_route('organization.abouts.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(About $about)
    {
        try {
            $this->service->delete(model: $about);

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
    }
}
