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

   

    public function isexpensepayer(User $user, Expense $expense): Response
    {
        //return $user->id === $expense->paid_by;

         if ($user->id !== $expense->paid_by) {
        return Response::deny('This Expense is not paid by authenticated user.');
        }
        return Response::allow();
    }

    public function show(User $user, Expense $expense): Response

    {     
        $group = $expense->group;
       $ismember=GroupService::isMember($group,$user->id);

       if (!$ismember) {
        return Response::deny('This authenticated user is not member of this expense group.');
        }
         return Response::allow();
    
    }

   


}
