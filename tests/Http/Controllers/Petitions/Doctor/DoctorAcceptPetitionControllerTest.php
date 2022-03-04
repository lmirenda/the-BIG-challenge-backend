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

class DoctorAcceptPetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_role_doctor_can_accept_pending_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->pending()->create();
        $user = User::factory()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);

        Auth::attempt(['email' => $user->email, 'password'=>123456]);

        $this
            ->putJson('api/petitions/accept/'.$petition->id)
            ->assertJsonMissing([PetitionStatus::PENDING->value])
            ->assertJsonFragment([PetitionStatus::TAKEN->value])
            ->assertSuccessful();
    }

    public function test_user_without_role_doctor_cant_accept_pending_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->pending()->create();
        $user = User::factory()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::PATIENT->value);

        Auth::attempt(['email' => $user->email, 'password'=>123456]);

        $this
            ->putJson('api/petitions/accept/'.$petition->id)
            ->assertStatus(403);
    }

    public function test_user_with_role_doctor_cant_accept_taken_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->taken()->create();
        $user = User::factory()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);

        Auth::attempt(['email' => $user->email, 'password'=>123456]);

        $this
            ->putJson('api/petitions/accept/'.$petition->id)
            ->assertStatus(422);
    }
}
