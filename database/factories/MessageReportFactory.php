<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageReportFactory extends Factory
{
    protected $model = MessageReport::class;

    public function definition()
    {
        return [
            'message_id' => Message::factory(),
            'reported_by' => User::factory(),
            'reason' => 'spam',
            'status' => 'pending',
        ];
    }
}
