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

    public function test_user_with_role_doctor_can_finish_accepted_petition()
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
    public function test_user_with_role_doctor_cant_finish_other_doctors_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->taken()->create();
        $user = User::factory()
            ->doctor()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);

        Auth::attempt(['email'=>$user->email, 'password'=>123456]);

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertStatus(403);
    }
    public function test_user_with_role_patient_cant_finish_doctors_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->taken()->create();
        $user = User::factory()
            ->patient()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);

        Auth::attempt(['email'=>$user->email, 'password'=>123456]);

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertStatus(403);
    }
    public function test_user_with_role_doctor_cant_finish_pending_petition()
    {
        $this->seed(RoleSeeder::class);
        $petition = Petition::factory()->pending()->create();
        $user = User::factory()
            ->doctor()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);

        Auth::attempt(['email'=>$user->email, 'password'=>123456]);

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertStatus(403);
    }
}
