<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Company;
use App\Models\Groups;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use PHPUnit\Metadata\Group;

class GroupService
{
    public static function create(array $data): Groups
    {    
         
         

    // 3. Merge owner ID, remove duplicates, and ensure clean values
   
 //return DB::connection('mongodb')->transaction(function () use ($data) {
     $ownerId = (string) request()->user()->id;
    // 4. Save to MongoDB
     $group=Groups::create([
        'name'        => $data['name'],
        'description' => $data['description'] ?? null,
        'owner_id'    => $ownerId,
        'member_ids'  => [$ownerId], // Saves as true BSON Array
        'deleted_at' =>  null,
    ]);        
           return $group;   
   // });


    }


    public static function update(Groups $group,array $data): Groups
    {  
        // $data['group_id'] = $expense->group->id;
        // $data['deleted_at'] = null; 
        $group->update($data);
        return $group->refresh();
     }


    public static function isMember(Groups $group, string $userId): bool
    {
        return in_array($userId, array_map('strval', $group->member_ids ?? []), true);
    
    }

    public static function addMember(Groups $group, string $user): Groups
    {   
        $userId = (string) $user;
        $group->push('member_ids', $userId, true);
        $group->refresh();
        
        return $group;
    }


     public static function removeMember(Groups $group, string $user): void
    {   
        $userId = (string) $user;
        $group->pull('member_ids', $userId);
        $group->refresh();
        
      //  return $group;
    }


    public static function getGroups()
    { 
        $id=request()->user()->id;
        return Groups::where('member_ids', (string) $id)->get();
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
