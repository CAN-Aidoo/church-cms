<?php

namespace Database\Factories;

use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceUnit>
 */
class ServiceUnitFactory extends Factory
{
    protected $model = ServiceUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'code' => strtoupper($this->faker->unique()->bothify('SU-##')),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement(['music', 'technical', 'hospitality', 'security', 'admin', 'children', 'media', 'other']),
            'min_members' => 2,
            'max_members' => 20,
            'current_members' => 0,
            'status' => 'active',
            'meeting_schedule' => 'Weekly on Fridays',
            'requirements' => $this->faker->sentence(),
            'responsibilities' => $this->faker->sentence(),
        ];
    }
}