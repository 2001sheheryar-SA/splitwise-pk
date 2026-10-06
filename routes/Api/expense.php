<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Middleware\AuthExpense;
use Illuminate\Support\Facades\Route;


Route::middleware('auth.token')->group(function () {
    
   
    Route::post('/groups/{group}/expense', [ExpenseController::class, 'store'])->middleware(AuthExpense::class);
    Route::get('/groups/{group}/expenses', [ExpenseController::class, 'index'])->middleware('can:show,group');
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])->middleware('can:show,expense');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->middleware('can:isowner,expense'); 
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->middleware(AuthExpense::class); 
    

  
});