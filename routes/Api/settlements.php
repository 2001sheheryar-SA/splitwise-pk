<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\SettlementController;
use App\Http\Middleware\AuthSettlement;
use Illuminate\Support\Facades\Route;


Route::middleware('auth.token')->group(function () {
    
  // Group Settlements
  
    Route::post('/groups/{group}/settlements', [SettlementController::class, 'store'])->middleware(AuthSettlement::class);
    Route::get('/groups/{group}/settlements', [SettlementController::class, 'index'])->middleware('can:show,group');
    Route::get('/settlements/{settlement}', [SettlementController::class, 'show'])->middleware('can:show,settlement');
    Route::put('/settlements/{settlement}', [SettlementController::class, 'update'])->middleware('can:ispayer,settlement');
    Route::delete('/settlements/{settlement}', [SettlementController::class, 'destroy'])->middleware('can:ispayer,settlement');


    Route::post('/attachments/{settlement}', [AttachmentController::class, 'store'])->middleware('can:ispayer,settlement');
    Route::get('/attachments/{attachment}', [AttachmentController::class, 'download'])->middleware('can:download,attachment');
    });