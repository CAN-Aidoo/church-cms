<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'category' => $this->faker->randomElement(['ministry', 'corporate_sponsor', 'media']),
            'contact_person' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'status' => 'active',
        ];
    }
}
