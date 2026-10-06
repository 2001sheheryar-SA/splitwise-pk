<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateSettlementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paid_by' => ['required', 'string'],
            'paid_to' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['required', 'string'],
           
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $paidBy = $this->input('paid_by');
                $paidTo= $this->input('paid_to');
              
                if ($paidBy === $paidTo) {
                   
                        $validator->errors()->add(
                            'same_users',
                            "Both Payer and receiver must be different users."
                        );
                    
                }

                
            }
        ];
    }


     public function messages(): array
    {
        return [
           'amount.min' => 'The amount field must be greater than 0.',    
        ];
    }

}
