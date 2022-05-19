<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->doctor()->create(['email' => 'doctor@lightit.io'])->assignRole(UserType::DOCTOR->value);

        User::factory()->patient()->create(['email' => 'patient@lightit.io'])->assignRole(UserType::DOCTOR->value);
    }
}
