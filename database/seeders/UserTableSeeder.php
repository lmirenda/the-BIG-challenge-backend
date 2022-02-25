<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Petition;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::factory()->doctor()->create();

        User::factory()->patient()->create();
    }
}
