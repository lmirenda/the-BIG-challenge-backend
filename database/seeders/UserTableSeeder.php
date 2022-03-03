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
        User::factory()->doctor()->create()->assignRole(UserType::DOCTOR->value);

        User::factory()->patient()->create()->assignRole(UserType::DOCTOR->value);
    }
}
