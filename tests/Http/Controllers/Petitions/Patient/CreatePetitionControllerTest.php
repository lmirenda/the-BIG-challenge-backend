<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Enums\UserType;
use App\Models\Patient;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreatePetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_create_a_petition()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()
            ->patient()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::PATIENT->value);
        Auth::attempt(['email'=>$user->email,'password'=>123456]);
        Patient::factory()->create(['user_id'=>$user->id]);
        $petitionData = [
            'title' => 'Test title.',
            'symptoms' => 'This are the symptoms.'
        ];
        $this
            ->assertAuthenticated()
            ->postJson('api/petitions/create', $petitionData)
            ->assertSuccessful();
    }
    public function test_doctor_cant_create_a_petition()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()
            ->doctor()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);
        Auth::attempt(['email'=>$user->email,'password'=>123456]);
        $petitionData = [
            'title' => 'Test title.',
            'symptoms' => 'This are the symptoms.'
        ];
        $this
            ->assertAuthenticated()
            ->postJson('api/petitions/create', $petitionData)
            ->assertForbidden();
    }
    public function test_logged_out_patient_cant_create_a_petition()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()
            ->patient()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::PATIENT->value);
        Patient::factory()->create(['user_id'=>$user->id]);
        $petitionData = [
            'title' => 'Test title.',
            'symptoms' => 'This are the symptoms.'
        ];
        $this
            ->postJson('api/petitions/create', $petitionData)
            ->assertForbidden();
    }
}
