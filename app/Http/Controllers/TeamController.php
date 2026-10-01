<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class TeamController extends Controller
{
    public function __construct(private readonly TeamService $teamService)
    {
    }

    /**
     * GET /api/teams
     */
    public static function index(Request $request): JsonResponse
    {
        $company = $request->user()->company;
        Gate::authorize('view', $company);

        $user = $request->user();
        $limit = $request->integer('limit', 10);
        
         $teams = $company->teams()
                ->where(function ($query) use ($user) {
                    $query->Where('created_by', $user->id)
                        ->orWhereHas('members', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                })
                ->withCount('channels')->paginate($limit);


        $message =  $teams->total() === 0 ? 'No Teams found.' : 'Teams fetched successfully.';
    

        return Response::success(
            $message,
            TeamResource::collection($teams)->resolve(),
            200,
            [
                'current_page' => $teams->currentPage(),
                'last_page' => $teams->lastPage(),
                'per_page' => $teams->perPage(),
                'total' => $teams->total(),
            ]
        );
    }

    /**
     * POST /api/teams
     */
    public function store(TeamRequest $request): JsonResponse
    {
       $company = $request->user()->company;

        Gate::authorize('update',$company);
       
        $team = $this->teamService->create($company, $request->validated());

        return Response::success('Team created successfully.', new TeamResource($team), 201);
    }

    /**
     * GET /api/teams/{team}
     */
    public function show(Request $request, Team $team): JsonResponse
    {
        Gate::authorize('view', $team);

        return Response::success('Team fetched successfully.', new TeamResource($team));
    }

    /**
     * PUT /api/teams/{team}
     */
    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        Gate::authorize('update', $team);
         
        $team = $this->teamService->update($team, $request->validated());

        return Response::success('Team updated successfully.', new TeamResource($team));
    }

    /**
     * DELETE /api/teams/{team}
     */
    public function destroy(Team $team): JsonResponse
    {
        Gate::authorize('delete', $team);

        $this->teamService->delete($team);

        return Response::success('Team deleted successfully.');
    }


    public function addMember(Team $team, User $user): JsonResponse
    {
        // Authorize using the 'addMember' policy method on Team, passing $user as targetUser
         Gate::authorize('addMember', [$team, $user]);

         $this->teamService->addmember($team, $user);

         return Response::success('Member added to team successfully.',new TeamResource($team), 201);
    }


    public function removeMember(TeamMember $teamMember): JsonResponse
    {
        
        $user=request()->user();
        if ($user->id == $teamMember->added_by)
        {
         $this->teamService->removeMember($teamMember);

         return Response::success('Member removed from team successfully.');
        }
        else
        {
             return Response::error('You are not authorized to perform this action.');
        }
    }

}
