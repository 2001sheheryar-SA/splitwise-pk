<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChannelPolicy
{
    /**
     * A user may only interact with channels whose team belongs to their company.
     */
    private function belongsToUserCompany(User $user, Channel $channel): bool
    {
        return $user->company_id === $channel->team->company_id;
    }

    public function view(User $user, Channel $channel): Response
    {
        //return $this->belongsToUserCompany($user, $channel);

        if (!$this->belongsToUserCompany($user,$channel)) {
            return Response::deny('You do not belong to the company that owns this channel.');
        }

        // 2. Public Channels: Viewable by anyone in the company/team
        if ($channel->type === 'public') { // Assuming an `is_private` boolean column on channels table
            return Response::allow();
        }

        $isCreator = $channel->created_by === $user->id;
        $isMember = $channel->members()->where('user_id', $user->id)->exists();

        if ($isCreator || $isMember) {
            return Response::allow();
        }

        return Response::deny('You are not a member of this private channel.');
    
    }


   
    public function update(User $user, Channel $channel): bool
    {
        return $user->company_id === $channel->team->company_id && $user->id=== $channel->created_by ;
    }

    public function delete(User $user, Channel $channel): bool
    {
        return $this->update($user, $channel);
    }

    public function addMember(User $user, Channel $channel, User $targetUser): Response
    {
        // 1. Authenticated user must belong to the team's company
        if (!$this->belongsToUserCompany($user, $channel)) {
            return Response::deny('Authenticated user do not belongs to above team company or dont have rights.');
        }

        // 2. Target user must belong to the same company
        if($targetUser->company_id !== $user->company_id) {
            return Response::deny('The target user does not belong to authenticated user\'s company.');
        }

        if (($channel->type=='private') && !$channel->members()->where('user_id', $user->id)->exists()) {
        return Response::deny('Cannot add members to a private channel you are not a member of.');
    }

        if(!$targetUser->teamMemberships()->where('team_id', $channel->team_id)->exists()) {
            return Response::deny('The target user does not belong to above channel team.');
        }

        if ($channel->members()->where('user_id', $targetUser->id)->exists()) {
            return Response::deny('The target user is already a member of this channel.');
        }

        return Response::allow();
    }


    public function sendmessage(User $user, Channel $channel): Response
    {
        
        if ($channel->members()->where('user_id', $user->id)->exists()) {
            return Response::allow();
        }
         return Response::deny('You are not a member of this  channel.');
    }
}
