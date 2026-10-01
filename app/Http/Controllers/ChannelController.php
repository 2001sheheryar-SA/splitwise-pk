<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelRequest;

use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Team;
use App\Models\User;
use App\Services\ChannelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Gate;

class ChannelController extends Controller
{
    public function __construct(private readonly ChannelService $channelService)
    {
    }

    /**
     * GET /api/teams/{team}/channels
     */
    public function index(Request $request, Team $team): JsonResponse
    {   
        Gate::authorize('view', $team);

        $limit = $request->integer('limit', 10);
        $user = $request->user();
        
        $channels = $team->channels()
        ->where(function ($query) use ($user) {
            $query->where('type', 'public')
                  ->orWhere('created_by', $user->id)
                  ->orWhereHas('members', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                  });
        })
        ->withCount('messages')
        ->paginate($limit);
       
        $message =  $channels->total() === 0 ? 'No channels found.' : 'Channels fetched successfully.';

        return Response::success(
            $message,
            ChannelResource::collection($channels)->resolve(),
            200,
            [
                'current_page' => $channels->currentPage(),
                'last_page' => $channels->lastPage(),
                'per_page' => $channels->perPage(),
                'total' => $channels->total(),
            ]
        );
    }

    /**
     * POST /api/teams/{team}/channels
     */
    public function store(ChannelRequest $request, Team $team): JsonResponse
    {
        Gate::authorize('view', $team);

        $channel = $this->channelService->create($team, $request->validated());

        return Response::success('Channel created successfully.', new ChannelResource($channel), 201);
    }

    /**
     * GET /api/channels/{channel}
     */
    public function show(Channel $channel): JsonResponse
    {
        Gate::authorize('view', $channel);

        return Response::success('Channel fetched successfully.', new ChannelResource($channel));
    }

    /**
     * PUT /api/channels/{channel}
     */
    public function update(ChannelRequest $request, Channel $channel): JsonResponse
    {
        Gate::authorize('update', $channel);

        $channel = $this->channelService->update($channel, $request->validated());

        return Response::success('Channel updated successfully.', new ChannelResource($channel));
    }

    /**
     * DELETE /api/channels/{channel}
     */
    public function destroy(Channel $channel): JsonResponse
    {
        Gate::authorize('delete', $channel);

        $this->channelService->delete($channel);

        return Response::success('Channel deleted successfully.');
    }


    public function addMember(Channel $channel, User $user): JsonResponse
    {
        // Authorize using the 'addMember' policy method on Team, passing $user as targetUser
         Gate::authorize('addMember', [$channel, $user]);
         $this->channelService->addmember($channel, $user);

        return Response::success('Member added to channel successfully.',new ChannelResource($channel), 201);
    }

    public function removeMember(ChannelMember $channelMember): JsonResponse
    {
       
        $user=request()->user();
        if ($user->id == $channelMember->added_by || $user->id === $channelMember->user_id)
        {
         $this->channelService->removeMember($channelMember);

        return Response::success('Channel Member removed from team successfully.');
        }
        else
        {
             return Response::error('You are not authorized to perform this action.');
        }
    }
}
