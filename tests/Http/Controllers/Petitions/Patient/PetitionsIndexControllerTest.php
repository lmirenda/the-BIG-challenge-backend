<?php

namespace Tests\Http\Controllers\Petitions\Patient;

use App\Enums\UserType;
use App\Http\Controllers\Petitions\Patient\PetitionsIndexController;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PetitionsIndexControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_patient_can_see_their_petitions()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()
            ->patient()
            ->create(['password'=>Hash::make(123456)])
            ->assignRole(UserType::PATIENT->value);

        Auth::attempt(['email' => $user->email, 'password' => 123456]);

        $this
            ->getJson('api/my/petitions')
            ->assertSuccessful();
    }

}
