<?php

namespace App\Http\Middleware;

use App\Models\EmailInvitation;
use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
class EmailLinkExpired
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        
        $plainTextToken = $request->query('token') ?? $request->route('token');


        if (empty($plainTextToken)) {
            return Response::error('Missing Email authentication token.', 401);
        }

       
       $emailtoken = EmailInvitation::where('token', $plainTextToken)->first();
        
        if (! $emailtoken) {
            return Response::error('Invalid Email authentication token.', 401);
        }

        if ($emailtoken->isExpired()) {
            return Response::error('Email Authentication token has expired.', 401);
        }
        

        return $next($request);
    }
}

