<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Groups;
use App\Models\Settlements;
use App\Models\User;
use App\Models\UserToken;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application with sample companies, teams, channels,
     * messages and users, following the same provisioning flow used
     * by real registration (company -> General team -> Announcements
     * channel), plus some extra teams/channels/messages for variety.
     */
    public function run(): void
    {
       

        // 1. Create 10+ Users
        $users = User::factory()->count(3)->create();
        $userIds = $users->pluck('id')->map(fn($id) => (string) $id)->toArray();

        // Split types required across expenses
        $splitTypes =  'exact';

        // 2. Create 3+ Groups with Multiple Members
        $groups = collect();

        for ($i = 0; $i < 4; $i++) {
            // Pick a random owner and a random subset of members (3 to 6 users)
            $ownerId = $userIds[array_rand($userIds)];
            $memberIds = array_unique(array_merge(
                [$ownerId],
                array_rand(array_flip($userIds), rand(2, 3))
            ));

            $group = Groups::factory()->create([
                'owner_id'   => $ownerId,
                'member_ids' => array_values($memberIds),
            ]);

            $groups->push($group);
        }

        // 3. Create 10+ Expenses with All 3 Split Types
        $expenseCount = 0;

        foreach ($groups as $groupIndex => $group) {
            $members = $group->member_ids;

           
               $paidBy = $members[array_rand($members)];
                // $paidBy = array_rand($members);
                $splitType ='equal'; // Ensures all 3 types are covered
                $amount = rand(2000, 10000) ; // e.g. 2,000.00 to 10,000.00

                // Generate splits structure based on split_type
                $splits = [];
                $memberCount = count($members);
                $share = round($amount / $memberCount, 2);
                foreach ($members as $memberId) {
                    $splits[] = [
                        'user_id' => $memberId,
                        'amount'  => $share,
                    ];
                }

                Expense::factory()->create([
                    'group_id'   => (string) $group->id,
                    'paid_by'    => $paidBy,
                    'amount'     => $amount,
                    'split_type' => $splitType,
                    'participants'     => $splits,
                ]);

                $expenseCount++;
            
        }

        // 4. Create Multiple Settlements
        foreach ($groups as $group) {
            $members = $group->member_ids;

            // Pick 2 distinct members from the group to settle up
            if (count($members) >= 2) {
                $payerId = $members[0];
                $payeeId = $members[1];

                Settlements::factory()->count(2)->create([
                    'group_id' => (string) $group->id,
                    'paid_by' => $payerId,
                    'paid_to' => $payeeId,
                    'amount'   => rand(5000, 10000) / 100,
                ]);
            }
        }
    }
}
