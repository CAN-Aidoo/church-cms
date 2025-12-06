<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageReadReceipt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageReadReceiptFactory extends Factory
{
    protected $model = MessageReadReceipt::class;

    public function definition()
    {
        return [
            'message_id' => Message::factory(),
            'user_id' => User::factory(),
            'delivered_at' => now(),
            'read_at' => now(),
        ];
    }
}
