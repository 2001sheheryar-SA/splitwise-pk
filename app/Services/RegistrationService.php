<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class RegistrationService
{
    public function __construct(private readonly TokenService $tokenService)
    {

    }

   
    public function register(array $data): array
    {
      return DB::connection('mongodb')->transaction(function () use ($data) {
            $user = User::create([
                'username' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'email_verified_at' => null,
              
            ]);

         

           return ['user' => $user];
       });
      
    }


   
}
