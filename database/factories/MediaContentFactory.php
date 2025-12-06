<?php

namespace Database\Factories;

use App\Models\MediaContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaContentFactory extends Factory
{
    protected $model = MediaContent::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content_type' => $this->faker->randomElement(['sermon_video', 'sermon_audio', 'event_video']),
            'content_date' => now(),
            'file_paths' => ['path/to/file.mp4'],
            'uploaded_by' => 1,
            'is_published' => true,
        ];
    }
}
