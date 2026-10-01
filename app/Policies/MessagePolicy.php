<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    /**
     * Any user in the same company as the message's channel/team may view it.
     */
    public function view(User $user, Message $message): bool
    {
        return $user->company_id === $message->channel?->team?->company_id or 
         $user->company_id === $message->user?->company_id;
    }

    /**
     * Only the author may update their own message.
     */
    public function update(User $user, Message $message): bool
    {
        return $user->id === $message->sender_id;
    }

    /**
     * The author, or the company owner, may delete a message.
     */
    public function delete(User $user, Message $message): bool
    {
        // if ($user->id === $message->user_id) {
        //     return true;
        // }

        // $company = $message->channel->team->company;

        // return $company && $user->isOwnerOf($company);
        return $user->id === $message->sender_id;
    }

    public function sendmessage(User $user, Message $message): bool
    {
        
        if ($message->channel->members()->where('user_id', $user->id)->exists()) {
            return true;
        }
        return false;
    }
}
