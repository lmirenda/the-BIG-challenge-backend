<?php

namespace Tests\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Models\Petition;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FinishPetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_role_doctor_can_accept_pending_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->taken()->create();
        Auth::attempt(['email' => 'test@doctor', 'password'=>123456]);

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertJsonMissing([PetitionStatus::TAKEN->value])
            ->assertJsonFragment([PetitionStatus::FINISHED->value])
            ->assertSuccessful();
    }
}
