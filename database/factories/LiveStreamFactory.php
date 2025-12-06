<?php

namespace Database\Factories;

use App\Models\LiveStream;
use App\Models\MediaTeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class LiveStreamFactory extends Factory
{
    protected $model = LiveStream::class;

    public function definition()
    {
        return [
            'stream_title' => $this->faker->sentence,
            'scheduled_start' => now()->addDay(),
            'platforms' => [$this->faker->randomElement(['youtube', 'facebook', 'other'])],
            'status' => $this->faker->randomElement(['scheduled', 'live', 'ended']),
            'technician_id' => MediaTeamMember::factory(), // Associate with a MediaTeamMember
        ];
    }
}
