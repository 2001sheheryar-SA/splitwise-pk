<?php


use App\Http\Controllers\GroupController;
use App\Http\Middleware\AuthGroup;
use Illuminate\Support\Facades\Route;


Route::middleware('auth.token')->group(function () {
    
    Route::post('/groups', [GroupController::class, 'store']);
    Route::get('/groups', [GroupController::class, 'show']);
    Route::put('/groups/{group}', [GroupController::class, 'update'])->middleware('can:isgroupowner,group');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->middleware('can:isgroupowner,group');
    
    Route::post('/groups/{group}/members', [GroupController::class, 'addMember'])->middleware(AuthGroup::class);
    Route::delete('/groups/{group}/members', [GroupController::class, 'removeMember'])->middleware(AuthGroup::class);
    Route::get('/groups/{group}/balances', [GroupController::class, 'showBalance'])->middleware('can:show,group');

    

    
});