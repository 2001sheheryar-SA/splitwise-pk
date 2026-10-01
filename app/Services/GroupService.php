<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Company;
use App\Models\Groups;
use App\Models\Message;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;

class GroupService
{
    public static function create(array $data): Groups
    {    
         
         $rawMembers = $data['member_ids'] ?? [];

    // 1. If sent as a string (from Form-Data / Postman), decode or wrap it
    if (is_string($rawMembers)) {
        $decoded = json_decode($rawMembers, true);
        $rawMembers = is_array($decoded) ? $decoded : explode(',', trim($rawMembers, '[] '));
    }

    // 2. Ensure it is a flat array
    if (!is_array($rawMembers)) {
        $rawMembers = [$rawMembers];
    }

    // 3. Merge owner ID, remove duplicates, and ensure clean values
    $ownerId = (string) request()->user()->id;
    
    $memberIds = array_values(array_unique(array_merge(
        [$ownerId],
        array_map('strval', $rawMembers) // Casts all elements to strings
    )));

    // 4. Save to MongoDB
     $group=Groups::create([
        'name'        => $data['name'],
        'description' => $data['description'] ?? null,
        'owner_id'    => $ownerId,
        'member_ids'  => $memberIds, // Saves as true BSON Array
    ]);                  


        return $group;



    }

    // public function update(Team $team, array $data): Team
    // {
        
    //     $team->update($data);
    //     return $team->refresh();
    // }

    // public function delete(Team $team): void
    // {   
    //     $channelIds = $team->channels()->pluck('id');
    //     ChannelMember::whereIn('channel_id', $channelIds)->delete();
    //     // 4. Delete channels
    //     $team->channels()->delete();
        
    //     TeamMember::where('team_id', $team->id)->delete();
    //     $team->delete();

    // }


    // public static function addmember(Team $team, User $user): void
    // {
        
    //      TeamMember::create([
    //         'team_id' => $team->id,
    //         'added_by' => $team->created_by,
    //         'user_id' => $user->id,   
    //     ]);

    // }


    // public static function removemember(TeamMember $teamMember): void
    // {
    //      $channelIds = $teamMember->team->channels()->pluck('id');
    //      ChannelMember::whereIn('channel_id', $channelIds)->delete();
    //      $teamMember->delete();
           

    // }
}
