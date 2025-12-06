<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\StarredMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StarredMessageFactory extends Factory
{
    protected $model = StarredMessage::class;

    public function definition()
    {
        return [
            'message_id' => Message::factory(),
            'user_id' => User::factory(),
        ];
    }
}
