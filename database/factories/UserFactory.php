<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['admin', 'pastor', 'staff', 'member']),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    /**
     * Indicate that the user is a pastor.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pastor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'pastor',
            ];
        });
    }

    /**
     * Indicate that the user is staff.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function staff()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'staff',
            ];
        });
    }
}
