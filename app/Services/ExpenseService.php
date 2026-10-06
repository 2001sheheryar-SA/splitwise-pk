<?php

namespace App\Services;

use App\Models\Groups;
use App\Models\Expense;
use App\Models\Message;
use App\Models\Settlements;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseService
{
    public function create(Groups $group,array $data): Expense
    {
        
        $participants = $data['participants'];

        // Filter out participants where amount is 0 (or float 0.0)
        $filteredParticipants = array_filter($participants, function ($participant) {
            return (float) $participant['amount'] > 0;
        });

        // Re-index array keys (optional, so keys are continuous: 0, 1, 2...)
        $data['participants'] = array_values($filteredParticipants);
        $data['deleted_at'] = null;

         //print_r($data);exit();

         

         return DB::connection('mongodb')->transaction(function () use ($group,$data) {

         $expense= Expense::create(array_merge( ['group_id' => $group->id], $data ));

         return $expense;
         });
       

    }

    public function update(Expense $expense,array $data): Expense
    {
        
        $data['group_id'] = $expense->group->id;
        $data['deleted_at'] = null;
        $expense->update($data);
        $expense->fresh();
        

        return  $expense;
    }

   

public static function getGroupBalances(string $groupId,string $settlementid=''): array
{
    $expenses = Expense::where('group_id', $groupId)->get();
    
    $balances = [];

    foreach ($expenses as $expense) {
        $payerId = $expense->paid_by;
        $totalAmount = (float) $expense->amount;

        // 1. Credit the payer
        if (!isset($balances[$payerId])) {
            $balances[$payerId] = 0;
          
        }
        $balances[$payerId] += $totalAmount;

        // 2. Debit each participant
        foreach ($expense->participants as $participant) {
            $userId = $participant['user_id'];
          
            $owedAmount = (float) $participant['amount'];

            if (!isset($balances[$userId])) {
                $balances[$userId] = 0;
            }

           $balances[$userId] -= $owedAmount;
            
        }
    }


    $settlements = empty($settlementid)? Settlements::where('group_id', $groupId)->get()
                   :Settlements::where('group_id', $groupId)->where('id', '!=', $settlementid)->get();
     //echo   $settlements ; exit();          
    

        foreach ($settlements as $settlement) {
            $payerId  = (string) $settlement->paid_by; // User who sent money
            $receiverId = (string) $settlement->paid_to; // User who received money
            $amount   = (float) $settlement->amount;

            // Credit the settlement payer (clears their negative balance)
            $balances[$payerId] ??= 0.0;
            $balances[$payerId] += $amount;

            // Debit the settlement receiver (clears their positive balance)
            $balances[$receiverId] ??= 0.0;
            $balances[$receiverId] -= $amount;
        }

   
    return $balances; // Returns array like: ['UserA' => 9000, 'UserB' => -3000, ...]
}
}
