<?php

namespace Database\Factories;

use App\Enums\UserType;
use App\Utilities\Random;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'type' => Random::userType(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function patient()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserType::PATIENT->value,
            ];
        });
    }

    public function doctor()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserType::DOCTOR->value,
            ];
        });
    }
}
