<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PetitionsIndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_see_their_petitions()
    {
        Sanctum::actingAs(
            User::factory()->patient()->create()
        );

        $this
            ->getJson('api/my/petitions')
            ->assertSuccessful();
    }
}
