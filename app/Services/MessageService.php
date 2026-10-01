<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function send(Channel $channel, User $user, string $body): Message
    {
        return Message::create([
            'sender_id' => $user->id,
            'channel_id' => $channel->id,
            'user_id' => 0,
            'message' => $body,
        ]);
    }

    public function senddm(User $user, User $sender, string $body): Message
    {
        return Message::create([
            'sender_id' => $sender->id,
            'channel_id' => 0,
            'user_id' =>  $user->id,
            'message' => $body,
        ]);
    }

    public function update(Message $message, string $body): Message
    {
        $message->update(['message' => $body]);

        return $message->refresh();
    }

    public function delete(Message $message): void
    {
        foreach ($message->attachments as $attachment) {
            AttachmentService::delete($attachment);
        }

        $message->delete();
    }
}
