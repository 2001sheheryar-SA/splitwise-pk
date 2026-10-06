<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserToken;

class TokenService
{
    /**
     * Issue a new random, unpredictable authentication token for a user.
     */
    public function issueTokenFor(User $user): UserToken
    {
        return UserToken::create([
            'user_id' => $user->id,
            'token' => UserToken::generatePlainTextToken(),
            'expires_at' => now()->addMinutes(60),
            
        ]);
    }

    /**
     * Invalidate (delete) the token currently used for the request.
     */
    public function revoke(string $token): void
    {
        
        UserToken::where('token', $token)->delete();
       
    }
}
