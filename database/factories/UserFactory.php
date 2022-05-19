<?php

namespace Database\Factories;

use App\Enums\UserType;
use App\Models\User;
use App\Utilities\Random;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

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
            'password' => Hash::make(123456),
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

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            try {
                Role::create(['name' => $user->type]);
            } catch (RoleAlreadyExists $exception) {
                // Do nothing
            }
            $user->assignRole($user->type);
        });
    }
}
