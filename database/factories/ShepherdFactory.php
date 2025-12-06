<?php

namespace Database\Factories;

use App\Models\Shepherd;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shepherd>
 */
class ShepherdFactory extends Factory
{
    protected $model = Shepherd::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'flock_name' => $this->faker->words(2, true) . ' Flock',
            'description' => $this->faker->sentence(),
            'max_flock_size' => 15,
            'current_flock_size' => 0,
            'status' => 'active',
            'appointed_date' => now(),
            'notes' => $this->faker->sentence(),
        ];
    }
}