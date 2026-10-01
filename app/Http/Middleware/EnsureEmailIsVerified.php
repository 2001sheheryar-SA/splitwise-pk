<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {   
         $user = $request->user();

        if (! $user && $request->has('email')) {
            $user = User::where('email', $request->input('email'))->first();
        }

        // 3. If user exists and email_verified_at is null, block access
        if ($user && is_null($user->email_verified_at)) {
             return Response::error('Please verify your email to sign in.', 403);
        }

        return $next($request);
        
    }
}
