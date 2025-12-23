<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->dateTimeBetween('-12 years', '-1 year')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'blood_group' => $this->faker->randomElement(['A+', 'O+', 'B+']),
            'allergies' => $this->faker->word(),
            'medical_conditions' => $this->faker->sentence(),
            'school' => $this->faker->company().' Elementary',
            'grade_level' => 'Grade '.$this->faker->numberBetween(1, 6),
            'is_active' => true,
            'notes' => $this->faker->sentence(),
        ];
    }
}
