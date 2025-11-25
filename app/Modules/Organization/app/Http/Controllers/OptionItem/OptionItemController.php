<?php

namespace App\Modules\Organization\app\Http\Controllers\OptionItem;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\OptionItem\OptionItemDto;
use App\Modules\Organization\app\Http\Request\OptionItem\StoreOptionItemRequest;
use App\Modules\Organization\app\Http\Request\OptionItem\UpdateOptionItemRequest;
use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use App\Modules\Organization\app\Services\OptionItem\OptionItemService;
use Exception;
use Illuminate\Http\Request;

class OptionItemController extends Controller
{
    public function __construct(protected OptionItemService $service)
    {
    }

    public function index(Request $request)
    {
        $query = OptionItem::whereOrganizationId(auth('organization_employee')->user()->organization_id);

        if ($request->filled('search')) {
            $query->whereTranslationLike('name', '%'.$request->search.'%');
        }

        if ($request->filled('option_id')) {
            $query->where('option_id', $request->option_id);
        }

        $option_items = $query->latest()->paginate(10);

        $options = Option::whereOrganizationId(auth('organization_employee')->user()->organization_id)->get();

        if ($request->ajax()) {
            return view('organization::dashboard.option_items.partials._table', compact('option_items'))->render();
        }

        return view('organization::dashboard.option_items.index', compact('option_items', 'options'));
    }

    public function create()
    {
        $options = Option::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.option_items.single', get_defined_vars());
    }

    public function store(StoreOptionItemRequest $request)
    {
        $this->service->store(OptionItemDto::fromArray($request));

        return to_route('organization.option_items.index')->with([
            'message' => __('messages.success'),
            'alert-type' => 'success',
        ]);
    }

    public function edit(OptionItem $option_item)
    {
        $options = Option::whereOrganizationId(auth()->user()->organization_id)->get();

        return view('organization::dashboard.option_items.single', get_defined_vars());
    }

    public function update(UpdateOptionItemRequest $request, OptionItem $option_item)
    {
        $this->service->update(model: $option_item, dto: OptionItemDto::fromArray($request));

        return to_route('organization.option_items.index')->with([
            'message' => __('messages.updated'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy(OptionItem $option_item)
    {
        try {
            $this->service->delete(model: $option_item);

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
