<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Message;
use App\Models\Team;
use App\Models\User;
use Laravel\Mcp\Request;

class ChannelService
{
    public static function create(Team $team, array $data): Channel
    {   
        $user =request()->user() ?? User::find($team->created_by);
        $channel= Channel::create([
            'team_id' => $team->id,
            'created_by' =>$user->id ,
            'name' => $data['name'],
            'type' => $data['type'],
            'description' => $data['description'] ?? null,
        ]);

         ChannelService::addmember($channel,$user);

        return $channel;
    }

    public function update(Channel $channel, array $data): Channel
    {
        $channel->update($data);

        return $channel->refresh();
    }

    public function delete(Channel $channel): void
    {   

        ChannelMember::where('channel_id', $channel->id)->delete();
        $channel->delete();
    }


    public static function addmember(Channel $channel, User $user): void
    {
        $user1 =request()->user() ?? User::find($channel->created_by);
         channelMember::create([
            'channel_id' => $channel->id,
            'added_by' => $user1->id,
            'user_id' => $user->id,   
        ]);

       
    }


    public static function removemember(ChannelMember $channelMember): void
    {
         
         $channelMember->delete();
           

    }


}
