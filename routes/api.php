<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmailInviteController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\EmailLinkExpired;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/verify-email/',[EmailInviteController::class, 'emailverified'])->middleware(EmailLinkExpired::class)->name('email.verify');
Route::post('/inviteregister/{token}', [AuthController::class, 'registerinvitation'])->middleware(EmailLinkExpired::class)->name('invite.register');

Route::middleware('auth.token')->group(function () {
    
    Route::get('/sendinvitation/{invitation}', [EmailInviteController::class, 'sendinvitation']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    //Route::get('/groups', [GroupController::class, 'store']);
    Route::post('/groups', [GroupController::class, 'store']);
    //Route::get('/company/teams', [GroupController::class, 'teams']);

    Route::apiResource('teams', TeamController::class);
    Route::post('/teams/{team}/members/{user}', [TeamController::class, 'addMember']);
    Route::delete('/teams/members/{teamMember}', [TeamController::class, 'removeMember']);

    Route::apiResource('teams.channels', ChannelController::class)->shallow();
    Route::post('/channels/{channel}/members/{user}', [ChannelController::class, 'addMember']);
    Route::delete('/channels/members/{channelMember}', [ChannelController::class, 'removeMember']);
    
    Route::apiResource('channels.messages', MessageController::class)->shallow();
    Route::post('/users/{user}/messages', [MessageController::class, 'dmmessage']);
    Route::get('/users/{user}/messages', [MessageController::class, 'dmindex']);

    Route::post('/messages/{message}/attachments', [AttachmentController::class, 'store']);
    
});




