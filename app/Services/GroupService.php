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
use Illuminate\Support\Facades\Log;
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
        
        $group->update($data);
        $group->refresh();


        return $group;
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

        
        
      
    }


    public static function getGroups()
    { 
        $id=request()->user()->id;
        return Groups::where('member_ids', (string) $id)->get();
    }

    
}
