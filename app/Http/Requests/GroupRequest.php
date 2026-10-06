<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => 'nullable|string',
           
        ];
    }


     public function messages(): array
    {
        return [
           // 'member_ids.*.exists' => 'This member  must be a valid user .',    
        ];
    }

}
