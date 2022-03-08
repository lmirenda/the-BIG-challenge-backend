<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PetitionsIndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_see_their_petitions()
    {
        $this->seed(RoleSeeder::class);
        Sanctum::actingAs(
            User::factory()->patient()->create()
        );

        $this
            ->getJson('api/my/petitions')
            ->assertSuccessful();
    }
}
