<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\ProgramRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramRegistrationFactory extends Factory
{
    protected $model = ProgramRegistration::class;

    public function definition()
    {
        return [
            'program_id' => Program::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'status' => 'confirmed',
            'registration_date' => now(),
        ];
    }
}
