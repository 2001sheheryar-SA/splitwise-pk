<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'created_by' => User::factory(),
            'type'=>'public',
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
