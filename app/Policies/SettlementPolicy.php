<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\Settlements;
use App\Models\Team;
use App\Models\User;
use App\Services\GroupService;
use Illuminate\Auth\Access\Response;

class SettlementPolicy
{
    /**
     * A user may only interact with channels whose team belongs to their company.
     */
    public function ispayer(User $user, Settlements $settlement): bool
    {
        return $user->id === $settlement->paid_by;
    }

    public function show (User $user, Settlements $settlement): Response
    {
       // return $user->id === $settlement->paid_by;
        $ismember=GroupService::isMember($settlement->group,$user->id);

       if (!$ismember) {
        return Response::deny('This authenticated user is not member of above settlement group.');
        }
         return Response::allow();
    }

    
}
