<?php

namespace Tests\Http\Controllers\Petitions\Doctor;

use Illuminate\Http\UploadedFile;
use App\Enums\PetitionStatus;
use App\Events\DoctorHasResponded;
use App\Mail\PetitionFinishedMail;
use App\Models\Petition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FinishPetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_role_doctor_can_finish_accepted_petition()
    {
        Event::fake();
        Storage::fake('petition_files');
        $file = UploadedFile::fake()->create('petition_response.txt');

        $petition = Petition::factory()->taken()->create();
        Sanctum::actingAs($petition->doctor);

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id, ['file' => $file])
            ->assertJsonMissing([PetitionStatus::TAKEN->value])
            ->assertJsonFragment([PetitionStatus::FINISHED->value])
            ->assertSuccessful();
        Event::assertDispatched(DoctorHasResponded::class);
//        Storage::disk('petition_response')->assertExists($file);
    }

    public function test_finishing_a_petition_queues_email_notification()
    {
        Storage::fake('petition_files');
        $file = UploadedFile::fake()->create('petition_response.txt');
        Mail::fake();
        $petition = Petition::factory()->taken()->create();
        Sanctum::actingAs($petition->doctor);

        $this
            ->putJson('api/petitions/accepted/finish/'.$petition->id, ['file' => $file])
            ->assertJsonMissing([PetitionStatus::TAKEN->value])
            ->assertSuccessful();
        Mail::assertQueued(PetitionFinishedMail::class, 1);
    }

    public function test_user_with_role_doctor_cant_finish_other_doctors_petition()
    {
        $petition = Petition::factory()->taken()->create();
        Sanctum::actingAs(User::factory()->doctor()->create());

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertStatus(403);
    }

    public function test_user_with_role_patient_cant_finish_doctors_petition()
    {
        $petition = Petition::factory()->taken()->create();
        Sanctum::actingAs(User::factory()->patient()->create());

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertStatus(403);
    }

    public function test_user_with_role_doctor_cant_finish_pending_petition()
    {
        $petition = Petition::factory()->pending()->create();
        Sanctum::actingAs(User::factory()->doctor()->create());

        $this
            ->assertAuthenticated()
            ->putJson('api/petitions/accepted/finish/'.$petition->id)
            ->assertStatus(403);
    }
}
