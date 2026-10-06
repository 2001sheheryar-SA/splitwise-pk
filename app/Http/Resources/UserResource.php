<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'email_verified_at'=>$this->email_verified_at,
          //  'company_id' => $this->company_id,
           // 'company_name' => Company::where('id',$this->company_id)->value('name'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
