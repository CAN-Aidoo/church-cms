<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'type' => 'conference',
            'category' => 'spiritual',
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'status' => 'published',
            'created_by' => User::factory(),
            'coordinator_id' => User::factory(),
        ];
    }
}
