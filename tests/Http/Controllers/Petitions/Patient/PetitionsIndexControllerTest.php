<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Models\Petition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PetitionsIndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_see_their_petitions()
    {
        $petition = Petition::factory()->create();
        $user = $petition->patient->user;
        Sanctum::actingAs($user);

        $this
            ->getJson('api/my/petitions')
            ->assertSuccessful();
    }
}
