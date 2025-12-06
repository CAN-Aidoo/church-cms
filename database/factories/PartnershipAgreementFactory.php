<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\PartnershipAgreement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnershipAgreementFactory extends Factory
{
    protected $model = PartnershipAgreement::class;

    public function definition(): array
    {
        return [
            'partner_id' => Partner::factory(),
            'agreement_title' => $this->faker->sentence,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active',
            'created_by' => User::factory(),
        ];
    }
}
