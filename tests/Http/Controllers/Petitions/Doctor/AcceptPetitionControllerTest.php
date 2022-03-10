<?php

namespace Tests\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Models\Petition;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AcceptPetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_role_doctor_can_accept_pending_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->pending()->create();
        Sanctum::actingAs(User::factory()->doctor()->create());

        $this
            ->putJson('api/petitions/accept/'.$petition->id)
            ->assertJsonMissing([PetitionStatus::PENDING->value])
            ->assertJsonFragment([PetitionStatus::TAKEN->value])
            ->assertSuccessful();
    }

    public function test_user_without_role_doctor_cant_accept_pending_petition()
    {
        $petition = Petition::factory()->pending()->create();
        Sanctum::actingAs(User::factory()->patient()->create());

        $this
            ->putJson('api/petitions/accept/'.$petition->id)->assertStatus(403);
    }

    public function test_user_with_role_doctor_cant_accept_taken_petition()
    {
        $petition = Petition::factory()->taken()->create();
        Sanctum::actingAs(User::factory()->doctor()->create());

        $this
            ->putJson('api/petitions/accept/'.$petition->id)
            ->assertStatus(403);
    }
}
