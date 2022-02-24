<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
                'type' => 'patient',
                'patient_symptoms' => $this->faker->text(200),
                'patient_height' => $this->faker->numberBetween(1.2,2.1),
                'patient_weight' => $this->faker->numberBetween(40,200),
                'patient_phone' => $this->faker->phoneNumber(),
                'patient_other_info' => $this->faker->text(50)
            ];
        });
    }

    public function doctor()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'doctor',
            ];
        });
    }
}
