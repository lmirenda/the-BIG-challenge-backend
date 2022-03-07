<?php

namespace Database\Factories;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Models\Patient;
use App\Models\User;
use App\Utilities\Random;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory
 */
class PetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = Random::petitionStatus();

        return [
            'title'=>$this->faker->name(),
            'symptoms' => $this->faker->text(200),
            'patient_id' => Patient::factory()->create(),
            'status' => $status,
            'doctor_id' => $status != PetitionStatus::PENDING->value
                ? User::factory()
                    ->doctor()
                    ->create()
                    ->assignRole(UserType::DOCTOR->value)
                : null,
        ];
    }

    public function taken()
    {
        return $this->state(function (array $attributes) {
            return [
                'doctor_id' => User::factory()
                    ->doctor()
                    ->create([
                        'email'=>'test@doctor',
                        'password' =>Hash::make(123456),
                    ])
                    ->assignRole(UserType::DOCTOR->value),
                'status' => PetitionStatus::TAKEN->value,
            ];
        });
    }

    public function finished()
    {
        return $this->state(function (array $attributes) {
            return[
                'doctor_id' => User::factory()
                    ->doctor()
                    ->create()
                    ->assignRole(UserType::DOCTOR->value),
                'status' => PetitionStatus::FINISHED->value,
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return[
                'doctor_id' => null,
                'status' => PetitionStatus::PENDING->value,
            ];
        });
    }
}
