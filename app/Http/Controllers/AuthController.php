<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Jobs\EmailJob;
use App\Mail\TestMail;
use App\Models\UserToken;
use App\Notifications\EmailNotification;
use App\Services\RegistrationService;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    use Notifiable;

    public function __construct(
        private  RegistrationService $registrationService,
        private  TokenService $tokenService,
    ) {
    }

    /**
     * POST /api/register
     *
     * Creates the user plus their company, General team and Announcements
     * channel, then returns an authentication token.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->registrationService->register($request->validated());
        //EmailInviteController::sendinvitation($result['user'],0);
        return  Response::success('Registration successful.', [
            'user' => new UserResource($result['user']),], 201);
    }

    /**
     * POST /api/login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        
        $user = \App\Models\User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
            throw new InvalidCredentialsException;
        }

        $token = $this->tokenService->issueTokenFor($user);


        return Response::success('Login successful.', [
            'user' => new UserResource($user),
            'token' => $token->token,
        ]);
    }

    /**
     * POST /api/logout
     *
     * Invalidates the token that was used to authenticate the current request.
     */
    public function logout(Request $request): JsonResponse
    {
     
        $token = $request->attributes->get('current_token');
        $this->tokenService->revoke($token);
        return Response::success('Logged out successfully.');
    }

    /**
     * GET /api/me
     */


    public function me(Request $request): JsonResponse
    {
        return Response::success('Current user fetched successfully.', new UserResource($request->user()));
    }




    // public function registerinvitation(Request $request,string $token): JsonResponse
    // {
        
    //     $user = \App\Models\EmailInvitation::where('token', $token)->first();
        
        
    //     $data= $request->validate([
    //         'name'     => ['required'],
    //         'email'    => ['required'],
    //         'password' => ['required'],
    //     ]);

    //     $this->registrationService->registerbyinvite($data, $user);
    
    //     \App\Models\EmailInvitation::where('token', $token)->delete();

    //     return Response::success('Registration successful you can now log in.');
       
    // }

}
