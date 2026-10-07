<?php

namespace Database\Factories;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settlements>
 */
class SettlementsFactory extends Factory
{
    public function definition(): array
    {
        return [
                    'group_id'   => Groups::factory(),
                    'paid_by'    => User::factory(),
                    'paid_to'    => User::factory(),
                    'amount'     => '',
                    'note' => fake()->sentence(),
                 
        ];
    }
}
