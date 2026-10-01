<?php

namespace App\Services;

use App\Models\EmailInvitation;
use App\Models\User;


class EmailService
{
    /**
     * Issue a new random, unpredictable authentication token for a user.
     */
    public static function createlink(User $user,array $data): void
    {
         EmailInvitation::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'invite' => $data['invite'],
            'token' => $data['token'],
            'expires_at' => $data['expires'],
            
        ]);
    }

    /**
     * Invalidate (delete) the token currently used for the request.
     */
    
}
