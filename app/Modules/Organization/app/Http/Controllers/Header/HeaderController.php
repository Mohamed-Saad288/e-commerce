<?php

namespace App\Modules\Organization\app\Http\Controllers\Header;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Header\HeaderDto;
use App\Modules\Organization\app\Http\Request\Header\StoreHeaderRequest;
use App\Modules\Organization\app\Http\Request\Header\UpdateHeaderRequest;
use App\Modules\Organization\app\Models\Header\Header;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Services\Header\HeaderService;
use Exception;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function __construct(protected HeaderService $service){}

    public function index()
    {
        $headers = $this->service->index();
        return view('organization::dashboard.headers.index', get_defined_vars());
    }
    public function create()
    {
        return view('organization::dashboard.headers.single',get_defined_vars());
    }
    public function store(StoreHeaderRequest $request)
    {
         $this->service->store(HeaderDto::fromArray($request));
        return to_route('organization.headers.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }
    public function edit(Header $header)
    {
        return view('organization::dashboard.headers.single', get_defined_vars());
    }
    public function update(UpdateHeaderRequest $request , Header $header)
    {
        $this->service->update(model: $header, dto: HeaderDto::fromArray($request));

        return to_route('organization.headers.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }
    public function destroy(Header $header)
    {
        try {
            if ($header->image && Storage::disk('public')->exists($header->image)) {
                Storage::disk('public')->delete($header->image);
            }
            $this->service->delete(model: $header);
            return response()->json([
                'success' => true,
                'message' => __('messages.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong')
            ], 500);
        }
    }


}
