<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Company;
use App\Models\Message;
use App\Models\Team;
use App\Models\TeamMember;
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
       
        Company::factory(1)
            ->create()
            ->each(function (Company $company) {
                $owner = $company->owner;
                $owner->update(['company_id' => $company->id]);

                UserToken::create([
                    'user_id' => $owner->id,
                    'token' => 'demo-token-'.$company->id,
                    'expires_at' => now()->addMinutes(60),
                ]);

                $generalTeam = Team::factory()->create([
                    'company_id' => $company->id,
                    'created_by' => $owner->id,
                    'name' => 'General',
                ]);

                TeamMember::factory()->create([
                    'team_id' => $generalTeam->id,
                    'added_by' => $owner->id,
                    'user_id' => $owner->id,
                ]);


               $channel= Channel::factory()->create([
                    'team_id' => $generalTeam->id,
                    'created_by' => $owner->id,
                    'name' => 'Announcements',
                ]);

                ChannelMember::factory()->create([
                    'channel_id' => $channel->id,
                    'added_by' => $owner->id,
                    'user_id' => $owner->id,
                ]);

                 Message::factory(3)->create([
                            'sender_id' => $owner->id,
                            'channel_id' => $channel->id,
                            'user_id' => 0,
                        ]);
                       

                

               
            });
    }
}
