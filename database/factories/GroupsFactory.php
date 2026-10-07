<?php

namespace Database\Factories;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Groups>
 */
class GroupsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'owner_id' => User::factory(),
            'member_ids' => [User::factory()],
        ];
    }
}
