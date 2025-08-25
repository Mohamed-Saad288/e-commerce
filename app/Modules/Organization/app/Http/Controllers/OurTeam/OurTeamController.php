<?php

namespace App\Modules\Organization\app\Http\Controllers\OurTeam;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\OurTeam\OurTeamDto;
use App\Modules\Organization\app\Http\Request\OurTeam\StoreOurTeamRequest;
use App\Modules\Organization\app\Http\Request\OurTeam\UpdateOurTeamRequest;
use App\Modules\Organization\app\Models\OurTeam\OurTeam;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Services\OurTeam\OurTeamService;
use Exception;
use Illuminate\Support\Facades\Storage;

class OurTeamController extends Controller
{
    public function __construct(protected OurTeamService $service){}

    public function index()
    {
        $our_teams = $this->service->index();
        return view('organization::dashboard.our_teams.index', get_defined_vars());
    }
    public function create()
    {
        return view('organization::dashboard.our_teams.single',get_defined_vars());
    }
    public function store(StoreOurTeamRequest $request)
    {
         $this->service->store(OurTeamDto::fromArray($request));
        return to_route('organization.our_teams.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }
    public function edit(OurTeam $our_team)
    {
        return view('organization::dashboard.our_teams.single', get_defined_vars());
    }
    public function update(UpdateOurTeamRequest $request , OurTeam $our_team)
    {
        $this->service->update(model: $our_team, dto: OurTeamDto::fromArray($request));

        return to_route('organization.our_teams.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }
    public function destroy(OurTeam $our_team)
    {
        try {
            if ($our_team->image && Storage::disk('public')->exists($our_team->image)) {
                Storage::disk('public')->delete($our_team->image);
            }
            $this->service->delete(model: $our_team);
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
