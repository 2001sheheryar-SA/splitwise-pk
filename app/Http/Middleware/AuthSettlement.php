<?php

namespace App\Http\Middleware;

use App\Models\Groups;
use App\Models\User;
use App\Models\UserToken;
use App\Services\GroupService;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate ;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Custom, hand-rolled Bearer token authentication.
 *
 * 1. Reads the Authorization header.
 * 2. Extracts the Bearer token.
 * 3. Looks it up in the user_tokens table.
 * 4. Rejects the request if it is missing, unknown, or expired.
 * 5. Otherwise resolves the owning user and binds it to the request
 *    (and to Laravel's auth manager) for the rest of the lifecycle.
 */
class AuthSettlement
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        $group = $request->route('group');
        $paidby=$request->input('paid_by');
        $paidto=$request->input('paid_to');
        
       // $ismember=GroupService::isMember($group, request()->user()->id);
       
      //  if (!$ismember) {return Response::error('This authenticated user is not member of this group.');}
        Gate::authorize('isowner',$group);
        // if($request->input('paid_by') === $request->input('paid_to')){

        // return Response::error('Both Payer and receiver must be different users.');
        // }
        Gate::authorize('ispaidBy',[$group,$paidby]);
        Gate::authorize('ispaidBy',[$group,$paidto]);

        // $paidBy = GroupService::isMember($group, $request->input('paid_by'));
       
        // if (!$paidBy) {return Response::error('This user specified in paid_by is not a member of this group.');}

        // $paidto = GroupService::isMember($group, $request->input('paid_to'));
       
        // if (!$paidto) {return Response::error('This user specified in paid_to is not a member of this group.');}
        
        
       

        
    

        return $next($request);
    }
}
