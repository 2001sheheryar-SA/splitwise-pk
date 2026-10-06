<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\Groups;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Services\GroupService;
use Illuminate\Auth\Access\Response ;



class ExpensePolicy
{
    /**
     * A user may only interact with teams that belong to their own company.
     */

   

    public function isowner(User $user, Expense $expense): bool
    {
        return $user->id === $expense->paid_by;
    }

    public function show(User $user, Expense $expense): Response

    {     
        $group = $expense->group;
       $ismember=GroupService::isMember($group,$user->id);

       if (!$ismember) {
        return Response::deny('This auth user is not member of this group.');
        }
         return Response::allow();
    
    }

   


}
