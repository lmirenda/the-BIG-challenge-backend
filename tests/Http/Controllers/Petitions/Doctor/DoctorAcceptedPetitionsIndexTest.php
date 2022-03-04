<?php

namespace Tests\Http\Controllers\Petitions\Doctor;

use App\Enums\UserType;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DoctorAcceptedPetitionsIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_access_accepted_petitions_route()
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()
            ->doctor()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::DOCTOR->value);

        Auth::attempt(['email'=>$user->email, 'password'=>123456]);

        $this
            ->getJson('api/petitions/accepted')
            ->assertSuccessful();
    }

    public function test_patient_cant_access_accepted_petitions_route()
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()
            ->patient()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::PATIENT->value);

        Auth::attempt(['email'=>$user->email, 'password'=>123456]);

        $this
            ->getJson('api/petitions/accepted')
            ->assertStatus(403);
    }
}
