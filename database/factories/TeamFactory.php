<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'created_by' => User::factory(),
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
