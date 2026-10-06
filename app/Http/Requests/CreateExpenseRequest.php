<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;

class CreateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        
             return true;
       
    }

    public function rules(): array
    {
        return [
           // 'group_id' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'paid_by' => ['required', 'string'],
            'split_type' => ['required', 'string', 'in:equal,percentage,exact'],
            
            // Validate nested participants array
            'participants' => ['required', 'array', 'min:1'],
            'participants.*.user_id' => ['required', 'string'],
            'participants.*.amount' => ['required_if:split_type,exact','nullable', 'numeric', 'min:0'],
            'participants.*.percentage' => ['required_if:split_type,percentage','nullable', 'numeric', 'min:0'],
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $splitType = $this->input('split_type');
                $totalAmount = (float) $this->input('amount');
                $participants = $this->input('participants', []);

                if ($splitType === 'exact') {
                    $sumAmount = array_sum(array_column($participants, 'amount'));

                    if (abs($sumAmount - $totalAmount) > 0.01) {
                        $validator->errors()->add(
                            'participants',
                            "The sum of participants' amounts ($sumAmount) must equal the total expense amount ($totalAmount)."
                        );
                    }
                }

                if ($splitType === 'percentage') {
                    $sumPercentage = array_sum(array_column($participants, 'percentage'));

                    if (abs($sumPercentage - 100) > 0.01) {
                        $validator->errors()->add(
                            'participants',
                            "The sum of participants' percentages ($sumPercentage%) must equal 100%."
                        );
                    }
                }
            }
        ];
    }


    /**
     * Automatically populate dynamic amounts for 'equal' or 'percentage' splits.
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);

        if (is_null($key)) {
            $totalAmount = (float) $validated['amount'];
            $count = count($validated['participants']);

            foreach ($validated['participants'] as &$participant) {
                if ($validated['split_type'] === 'equal') {
                    $participant['amount'] = round($totalAmount / $count, 2);
                    unset($participant['percentage']);
                } elseif ($validated['split_type'] === 'percentage') {
                    $participant['amount'] = round(($totalAmount * ((float) $participant['percentage'])) / 100, 2);
                }
            }

            return $validated;
        }

        return $validated;
    }

     public function messages(): array
    {
        return [
            'split_type.in' => "Only Split_type equal,percentage,exact are allowed",
            'amount.min' => 'The amount field must be greater than 0.',
            'participants.*.amount.required_if' => 'Participant amount is required when split_type is exact.',
            'participants.*.percentage.required_if' => 'Participant percentage is required when split_type is percentage.',
          
        ];
    }
}