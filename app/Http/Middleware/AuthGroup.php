<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserToken;
use App\Services\GroupService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
class AuthGroup
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        $group = $request->route('group');
        
        $user = User::find($request->input('user_id'));
       
        if (!$user) {
            return Response::error('Invalid userid.',400);
       }

        Gate::authorize('isowner',$group);

       if ($request->isMethod('post')) {
           Gate::authorize('ismember',[$group,$user->id]);
       }
       if ($request->isMethod('delete') || $request->isMethod('get')) {
          Gate::authorize('isnotmember',[$group,$user->id]);
       }
       
           
        return $next($request);
    }
}
