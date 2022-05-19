<?php

namespace Database\Seeders;

use App\Models\Petition;
use Illuminate\Database\Seeder;

class PetitionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Petition::factory()->count(10)->create();
        Petition::factory()->pending()->count(5)->create();
    }
}
