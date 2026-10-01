<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChannelMember>
 */
class ChannelMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     protected $model = ChannelMember::class;
    public function definition(): array
    {
        return [
            'channel_id' => Channel::factory(),
            'added_by' => User::factory(),
            'user_id' => User::factory(),
            
        ];
    }
}
