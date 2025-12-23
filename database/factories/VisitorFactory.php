<?php

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'visit_date' => $this->faker->date(),
            'service_type' => 'Sunday Service',
            'how_heard' => $this->faker->randomElement(['Friend', 'Social Media', 'Website', 'Drive-by']),
            'follow_up_required' => true,
            'follow_up_status' => 'pending',
            'visit_count' => 1,
        ];
    }
}
