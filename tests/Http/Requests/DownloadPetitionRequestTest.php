<?php

namespace Tests\Http\Requests;

use App\Models\Petition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DownloadPetitionRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_cant_download_other_patient_finished_petition()
    {
        $petition = Petition::factory()->finished()->create();
        UploadedFile::fake()->create($petition->file, 10, 'application/txt');
        Sanctum::actingAs(User::factory()->patient()->create());

        $this
            ->assertAuthenticated()
            ->getJson('/api/petitions/download/' . $petition->id)
            ->assertForbidden();
    }

    public function test_doctor_cant_download_other_patient_finished_petition()
    {
        $petition = Petition::factory()->finished()->create();
        UploadedFile::fake()->create($petition->file, 10, 'application/txt');
        Sanctum::actingAs(User::factory()->doctor()->create());

        $this
            ->assertAuthenticated()
            ->getJson('/api/petitions/download/' . $petition->id)
            ->assertForbidden();
    }
}
