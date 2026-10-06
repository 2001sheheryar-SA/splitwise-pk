<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddGroupMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            
           'user_id' => 'required|string',
          
        ];
    }


     public function messages(): array
    {
        return [
          // 'members.*.exists' => 'This member  is not a valid user .',    
        ];
    }

}
