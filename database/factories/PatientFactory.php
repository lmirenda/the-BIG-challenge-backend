<?php

namespace Database\Factories;

use App\Models\Patient;
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
            'patient_id' => User::where('type','patient')->inRandomOrder()->first()->id,
            'patient_symptoms' => $this->faker->text(200),
            'patient_height'=>$this->faker->number(120,230),
            'patient_weight'=>$this->faker->number(40,200),
            'patient_phone'=>$this->faker->phoneNumber(),
           'patient_other_info'=>$this->faker->text(50),
        ];
    }
}
