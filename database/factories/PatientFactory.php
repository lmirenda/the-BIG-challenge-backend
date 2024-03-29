<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->patient()->create(),
            'patient_height'=>$this->faker->randomNumber(3),
            'patient_weight'=>$this->faker->randomNumber(2),
            'patient_phone'=>$this->faker->phoneNumber(),
            'patient_other_info'=>$this->faker->text(),
        ];
    }
}
