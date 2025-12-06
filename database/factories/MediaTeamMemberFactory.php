<?php

namespace Database\Factories;

use App\Models\MediaTeamMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaTeamMemberFactory extends Factory
{
    protected $model = MediaTeamMember::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'primary_role' => $this->faker->randomElement([
                'media_director', 'camera_operator', 'sound_engineer',
                'graphics_designer', 'video_editor', 'streaming_technician',
                'photographer', 'other',
            ]),
            'skills' => $this->faker->randomElements(['Video Editing', 'Photography', 'Audio Mixing', 'Live Streaming'], 2),
            'is_active' => true,
            'joined_date' => now()->subMonths(rand(1, 12)),
        ];
    }
}
