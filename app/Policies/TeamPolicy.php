<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Auth\Access\Response ;
//use Illuminate\Support\Facades\Response;


class TeamPolicy
{
    /**
     * A user may only interact with teams that belong to their own company.
     */

   

    private function belongsToUserCompany(User $user, Team $team): bool
    {
        return $user->company_id === $team->company_id && $user->id === $team->created_by;
    }

    public function view(User $user, Team $team): Response
    {
        //return $user->company_id === $team->company_id;
        if (!$team->members()->where('user_id', $user->id)->exists()) {
            return Response::deny('The authenticated user not member of this team.');
        }

        return Response::allow();
    }

    public function update(User $user, Team $team): bool
    {
        return $this->belongsToUserCompany($user, $team);
    }

    public function delete(User $user, Team $team): bool
    {
        return $this->belongsToUserCompany($user, $team);
    }

    public function addMember(User $user, Team $team, User $targetUser): Response
    {
        // 1. Authenticated user must belong to the team's company
        if (!$this->belongsToUserCompany($user, $team)) {
            return Response::deny('Authenticated user do not belongs to above team company or dont have rights.');
        }

        // 2. Target user must belong to the same company
        if($targetUser->company_id !== $user->company_id) {
            return Response::deny('The target user does not belong to authenticated user\'s company.');
        }

        if ($team->members()->where('user_id', $targetUser->id)->exists()) {
            return Response::deny('The target user is already a member of this team.');
        }

        return Response::allow();
    }


    



    


}
