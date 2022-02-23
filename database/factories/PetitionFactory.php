<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petition>
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
            'patient' => User::where('type','patient')->random()->id,
            'status' => $status[rand(0,2)],
            'doctor' => $status != 'pending'
                ? User::where('type', 'doctor')->random()->id
                : null,
        ];
    }
}
