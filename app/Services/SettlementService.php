<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Groups;
use App\Models\Message;
use App\Models\Settlements;
use App\Models\Team;
use App\Models\User;
use Laravel\Mcp\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SettlementService
{
    public static function create(Groups $group, array $data): Settlements
    {   
       
        $settlement= Settlements::create([
            'group_id' => $group->id,
            'paid_by' => $data['paid_by'] ,
            'paid_to' => $data['paid_to'],
            'note' => $data['note'],
            'amount' => $data['amount'],
            'deleted_at' =>  null,
        ]);

       

        return $settlement;
    }

    public function update(Settlements $settlement, array $data): Settlements
    {
        $settlement->update($data);

        return $settlement->refresh();
    }

    // public function delete(Channel $channel): void
    // {   

    //     ChannelMember::where('channel_id', $channel->id)->delete();
    //     $channel->delete();
    // }


    public static function validateSettlement(array $balances, string $payerId, float $settleAmount): ?SymfonyResponse
{
    // 1. Get current balance for the payer (default to 0 if not present)
    $payerBalance = $balances[$payerId] ?? 0.0;

    // A positive or zero balance means the user does NOT owe any money
    if ($payerBalance >= 0) {
        return Response::error('This paid_by user has no outstanding debt to settle.');
            
    }
    

    // Convert negative balance to a positive debt figure (e.g., -3000 becomes 3000)
    $maxAllowedDebt = abs($payerBalance);
    

    // 2. Check if settlement amount exceeds outstanding debt
    if ($settleAmount > $maxAllowedDebt) {
    
        return Response::error("Settlement amount ({$settleAmount}) cannot exceed the outstanding debt of {$maxAllowedDebt}.",422);
        
    }

 //$payeeBalance = $balances[$payeeId] ?? 0.0;
    //if ($payeeBalance <= 0) {
    //     return [
    //         'valid'   => false,
    //         'message' => 'The receiving user is not owed any money in this group.',
    //     ];
    // }

    // if ($settleAmount > $payeeBalance) {
    //     return [
    //         'valid'   => false,
    //         'message' => "Settlement amount ({$settleAmount}) exceeds what the receiver is owed ({$payeeBalance}).",
    //     ];
    // }

    return  null;
}

    


}
