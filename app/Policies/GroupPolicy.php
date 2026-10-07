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
    
    public function isgroupowner(User $user, Groups $group): Response

    {  
    
       /// return $user->id === $group->owner_id;

        if ($user->id !== $group->owner_id) {
        return Response::deny('This authenticated user is not owner of this group.');
        }
        return Response::allow();
    }


    public function show (User $user, Groups $group): Response

    {  
    
        $ismember=GroupService::isMember($group,$user->id);

       if (!$ismember) {
        return Response::deny('This authenticated user is not member of this group.');
        }
         return Response::allow();
    
    }


    
    public function isnotgroupmember (User $user, Groups $group,string $userid,string $msg=''): Response

    {  
    
        $ismember=GroupService::isMember($group,$userid);

       if (!$ismember) {
        return Response::deny($msg);
        }
         return Response::allow();
    
    }


    public function isgroupmember (User $user, Groups $group,string $userid,string $msg=''): Response

    {  
    
        $ismember=GroupService::isMember($group,$userid);

       if ($ismember) {
        return Response::deny($msg);
        }
         return Response::allow();
    
    }


   

    public function participants(User $user,Groups $group,array $participants): Response
    {
       

        if (is_array($participants)) {
            foreach ($participants as $participant) {
                $userId = $participant['user_id'] ?? null;
                
                if ($userId && !GroupService::isMember($group, $userId)) {
                    return Response::deny("Participant user {$userId} is not a member of this group.",422);
                }
            }
        }
       
        
        return Response::allow();
    }
}
