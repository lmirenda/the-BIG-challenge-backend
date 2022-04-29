<?php

namespace Tests\Http\Controllers\Petitions;

use App\Http\Controllers\Petitions\ViewPetitionController;
use App\Models\Petition;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewPetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_access_endpoint()
    {
        $this->seed(RoleSeeder::class);

        Sanctum::actingAs(
            User::factory()->doctor()->create()
        );

        $petition = Petition::factory()->create();

        $this
            ->assertAuthenticated()
            ->getJson('/api/petitions/' . $petition->id)
            ->assertSuccessful();
    }

}
