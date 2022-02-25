<?php

namespace Database\Factories;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Models\Patient;
use App\Models\User;
use App\Utilities\Random;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'description' => $this->faker->text(200),
            'patient_id' => Patient::factory(),
            'status' => $status,
            'doctor_id' => $status != PetitionStatus::PENDING
                ? User::factory()->doctor()
                : null,
        ];
    }

    public function taken()
    {
        return $this->state(function (array $attributes){
            return [
                'patient_id' => User::factory()->doctor(),
                'status' => PetitionStatus::TAKEN
            ];
        });
    }

    public function finished()
    {
        return $this->state(function (array $attributes){
            return[
                'doctor_id' => User::factory()->doctor(),
                'status' => PetitionStatus::FINISHED
            ];
        });
    }
}
