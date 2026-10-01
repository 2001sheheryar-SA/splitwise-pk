<?php

namespace App\Http\Middleware;

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
class AuthToken
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        
        $plainTextToken = $request->header('AuthorizationKey');

        if (empty($plainTextToken)) {
            return Response::error('Missing authentication token.', 401);
        }

        /** @var UserToken|null $token */
       $token = UserToken::with('user')->where('token', $plainTextToken)->first();
        
        if (! $token) {
            return Response::error('Invalid authentication token.', 401);
        }

        if ($token->isExpired()) {
            return Response::error('Authentication token has expired.', 401);
        }
        
        Auth::setUser($token->user);
        $request->setUserResolver(fn () => $token->user);
        $request->attributes->set('current_token', $plainTextToken);

        return $next($request);
    }
}
