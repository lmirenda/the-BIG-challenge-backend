<?php

namespace Tests\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Events\DoctorHasResponded;
use App\Mail\PetitionFinishedMail;
use App\Mail\RegisterNewUserMail;
use App\Models\Petition;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FinishPetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_role_doctor_can_finish_accepted_petition()
    {
        Event::fake();
        $petition = Petition::factory()->taken()->create();
        Sanctum::actingAs(
            User::where('id', $petition->doctor_id)->first()
        );
        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertJsonMissing([PetitionStatus::TAKEN->value])
            ->assertJsonFragment([PetitionStatus::FINISHED->value])
            ->assertSuccessful();
        Event::assertDispatched(DoctorHasResponded::class);
    }
    public function test_finishing_a_petition_queues_email_notification()
    {
        Mail::fake();
        $petition = Petition::factory()->taken()->create();
        $user = User::where('id', $petition->doctor_id)->first();

        Sanctum::actingAs($user);

        $this
                ->putJson('api/petitions/accepted/finish/'.$petition->id)
                ->assertJsonMissing([PetitionStatus::TAKEN->value])
                ->assertSuccessful();
        Mail::assertQueued(PetitionFinishedMail::class, 1);

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
