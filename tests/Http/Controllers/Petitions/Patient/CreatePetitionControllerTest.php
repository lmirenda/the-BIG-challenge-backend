<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_create_a_petition()
    {
        $user = Sanctum::actingAs(
            User::factory()->patient()->create()
        );

        Patient::factory()->create(['user_id'=>$user->id]);

        $this
            ->assertAuthenticated()
            ->postJson('api/petitions/create', [
                'title' => 'Test title.',
                'symptoms' => 'This are the symptoms.',
            ])
            ->assertSuccessful();
    }

    public function test_doctor_cant_create_a_petition()
    {
        Sanctum::actingAs(
            User::factory()->doctor()->create()
        );

        $this
            ->assertAuthenticated()
            ->postJson('api/petitions/create', [
                'title' => 'Test title.',
                'symptoms' => 'This are the symptoms.',
            ])
            ->assertForbidden();
    }

    public function test_logged_out_patient_cant_create_a_petition()
    {
        $petitionData = [
            'title' => 'Test title.',
            'symptoms' => 'This are the symptoms.',
        ];
        $this
            ->postJson('api/petitions/create', $petitionData)
            ->assertForbidden();
    }
}
