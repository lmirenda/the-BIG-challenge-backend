<?php

namespace Database\Factories;

use App\Models\User;
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
        $status = ['pending', 'in progress', 'done'][rand(0,2)];

        return [
            'title'=>$this->faker->name(),
            'description' => $this->faker->text(200),
            'patient_id' => User::where('type','patient')->inRandomOrder()->first()->id,
            'status' => $status,
            'doctor_id' => $status != 'pending'
                ? User::where('type','doctor')->inRandomOrder()->first()->id
                : null,
        ];
    }
}
