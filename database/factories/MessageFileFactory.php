<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFileFactory extends Factory
{
    protected $model = MessageFile::class;

    public function definition()
    {
        return [
            'message_id' => Message::factory(),
            'file_name' => $this->faker->word.'.pdf',
            'file_path' => 'path/to/file.pdf',
            'file_type' => 'application/pdf',
            'file_size' => 1024,
        ];
    }
}
