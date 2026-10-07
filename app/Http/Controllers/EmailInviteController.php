<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\Models\EmailInvitation;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class EmailInviteController extends Controller
{
    //


    // public static function sendinvitation(User $user, int $invitation)
    // {   
    //    $email=$user['email'];

    //    if ($invitation === 1) {
    //         $validatedData = request()->validate([
    //              'email' => ['required', 'email', 'unique:users,email'],
    //             ],['email.unique' => 'This email address is already registered in the db.'
    //             ]);
    //       $email= $validatedData['email'];
    //       $user= request()->user();
    //     } 

    //     $data['token'] = bin2hex(random_bytes(32));
    //     $data['expires']=now()->plus(minutes: 120)->timestamp;
    //     $data['invite']=$invitation;

    //     EmailService::createlink($user,$data);
    //     EmailJob::dispatch($email, $data['token'], $data['expires'],$data['invite']);

    //     return Response::success('Company Invite Link has been sent to above  email.');

    // }


    public function emailverified(Request $request)
    {   
        $token = $request->query('token');
        $invite = $request->query('invite');

        if ($invite == 0) {
            $record = EmailInvitation::where('token', $token)->first();
            $user = User::find($record->user_id);
            if (!is_null($user->email_verified_at)) {
                return Response::success('Your email is already verified.');
            }
            // Mark email as verified
            $user->update(['email_verified_at' => now()]);
            return Response::success('Your email has been verified.');
        }
        else
        {
              return view('auth.register');
        }

    }




    
    // public  function sendinvitation(Request $request)
    // {   
        
    // //   $signedUrl = URL::temporarySignedRoute(
    // //         'email.verify', now()->plus(minutes: 120),
    // //     );

    //     $validatedData = $request->validate([
    //             'email' =>  ['required', 'email'],
    //             ]);
                
         
    //     $data['token'] = bin2hex(random_bytes(32));
    //     $data['expires']=now()->plus(minutes: 120)->timestamp;
    //     EmailService::createlink($request->user(),$data);
                
       
    //    EmailJob::dispatch($validatedData['email'], $data['token'], $data['expires']);

    //    return Response::success('Company Invite Link has been sent to above  email.');

    // }
    
}
