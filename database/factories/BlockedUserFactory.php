<?php

namespace Database\Factories;

use App\Models\BlockedUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockedUserFactory extends Factory
{
    protected $model = BlockedUser::class;

    public function definition()
    {
        return [
            'blocker_id' => User::factory(),
            'blocked_id' => User::factory(),
            'reason' => $this->faker->sentence,
        ];
    }
}
