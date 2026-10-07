<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            
                    'group_id'   => Groups::factory(),
                    'description' => fake()->sentence(),
                    'amount'     => '',
                    'paid_by'    => User::factory(),
                    'split_type' => '',
                    'participants'     => [],
        ];
    }
}
