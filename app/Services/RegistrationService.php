<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Company;
use App\Models\EmailInvitation;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseCount;

class RegistrationService
{
    public function __construct(private readonly TokenService $tokenService)
    {

    }

   
    public function register(array $data): array
    {
       
            $user = User::create([
                'username' => $data['name'],
                'email' => $data['email'],
               // 'role' => 'admin',
                'password' => $data['password'],
                'email_verified_at' => null,
               // 'created_at' => now()->timezone('Asia/Karachi')->toIso8601String(),
            ]);

            // $company = Company::create([
            //     'name' =>  $data['company'],
            //     'owner_id' => $user->id,
            // ]);

            // User::where('id', $user->id)->update([
            //     'company_id' =>  $company->id,
            // ]);
    //         $user->update([
    //     'company_id' => $company->_id,
    // ]);

            // $user=User::find($user->id);

            // $team = TeamService::create($company,['name' =>'General']);

            // $channel = ChannelService::create($team ,['name' =>'Announcements','type' =>'public']);
            
          
           return ['user' => $user];

      
    }


   
}
