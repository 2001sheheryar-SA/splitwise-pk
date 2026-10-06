<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this->resource expects an associative array or object containing:
        // ['group_id' => '...', 'balances' => ['user_id' => amount, ...]]
        
        $groupId = $this->resource['group_id'] ?? null;
        $rawBalances = $this->resource['balances'] ?? [];

        // 1. Fetch user names in ONE batch query using MongoDB _id
        $userIds = array_keys($rawBalances);
        $userNames = User::whereIn('id', $userIds)->pluck('username', 'id');

        // 2. Map raw balances to formatted array
        $formattedBalances = [];
        foreach ($rawBalances as $userId => $balance) {
            // Convert Stringable / ObjectId to string
            $userIdStr = (string) $userId;

            $formattedBalances[] = [
                'user_id' => $userIdStr,
                'name'    => $userNames[$userIdStr] ?? 'Unknown User',
                'balance' => (float) $balance,
            ];
        }

        return [
            'group_id' => (string) $groupId,
            'balances' => $formattedBalances,
        ];
    
    }
}
