<?php

namespace Database\Factories;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
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
        $status = PetitionStatus::cases();
        return [
            'title'=>$this->faker->name(),
            'description' => $this->faker->text(200),
            'patient_id' => User::where('type',UserType::PATIENT)->inRandomOrder()->first()->id,
            'status' => array_rand($status),
            'doctor_id' => $status != PetitionStatus::PENDING
                ? User::where('type','doctor')->inRandomOrder()->first()->id
                : null,
        ];
    }

    public function taken()
    {
        return $this->state(function (array $attributes){
            return [
                'patient_id' => User::where('type','patient')->inRandomOrder()->first()->id,
                'status' => PetitionStatus::TAKEN
            ];
        });
    }

    public function finished()
    {
        return $this->state(function (array $attributes){
            return[
                'doctor_id' => User::where('type','doctor')->inRandomOrder()->first()->id,
                'status' => PetitionStatus::FINISHED
            ];
        });
    }
}
