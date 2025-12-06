<?php

namespace Database\Factories;

use App\Models\ServiceSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceScheduleFactory extends Factory
{
    protected $model = ServiceSchedule::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3).' Service',
            'service_type' => 'regular',
            'service_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'status' => 'scheduled',
            'created_by' => User::factory(),
        ];
    }
}
