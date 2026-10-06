<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Groups;
use App\Models\User;
use App\Services\GroupService;
use Illuminate\Auth\Access\Response ;
//use Illuminate\Support\Facades\Response;

class GroupPolicy
{
    /**
     * Any member of the company may view it.
     */
    public function isowner(User $user, Groups $group): bool

    {  
    
        return $user->id === $group->owner_id;
    }


    public function show (User $user, Groups $group): Response

    {  
    
        $ismember=GroupService::isMember($group,$user->id);

       if (!$ismember) {
        return Response::deny('This authenticated user is not member of this group.');
        }
         return Response::allow();
    
    }


    public function ispaidBy (User $user, Groups $group,string $paidby): Response

    {  
    
        $ismember=GroupService::isMember($group,$paidby);

       if (!$ismember) {
        return Response::deny('This user specified in paid_by/paid_to is not a member of this group.');
        }
         return Response::allow();
    
    }


    public function ismember (User $user, Groups $group, string $member): Response

    {  
    
         $ismember=GroupService::isMember($group,$member);

       if ($ismember) {
        return Response::deny('This user is already member of this group.');
        }
         return Response::allow();
    
    }


    public function isnotmember (User $user, Groups $group, string $member): Response

    {  
    
         $ismember=GroupService::isMember($group,$member);

       if (!$ismember) {
        return Response::deny('This user is not member of this group.');
        }
         return Response::allow();
    
    }

    /**
     * Only the owner may update company details.
     */
    public function participants(User $user,Groups $group,array $participants,float $amount=null): Response
    {
       // $participants = $request->input('participants', []);
        $sumamt=0.0;

        if (is_array($participants)) {
            foreach ($participants as $participant) {
                $userId = $participant['user_id'] ?? null;
                // $sumamt += $participant['amount'];
                if ($userId && !GroupService::isMember($group, $userId)) {
                    return Response::deny("Participant user {$userId} is not a member of this group.",422);
                }
            }
        }
       
        // if($sumamt !== $amount){
        // return Response::deny("The Amount must be equal to all participants sum amount .",422);
        // }

        return Response::allow();
    }
}
