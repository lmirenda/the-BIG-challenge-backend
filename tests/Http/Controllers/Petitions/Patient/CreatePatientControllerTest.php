<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePatientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_role_patient_can_fill_patient_information()
    {
        $user = Sanctum::actingAs(
            User::factory()->patient()->create()
        );

        $this
            ->assertAuthenticated()
            ->postJson('api/patient/create', [
                'user_id' => $user->id,
                'patient_height' => 180,
                'patient_weight' => 100,
                'patient_phone' => '26000000',
                'patient_other_info' => 'no other info',
            ])
            ->assertSuccessful()
            ->assertSee('data');
    }
}
