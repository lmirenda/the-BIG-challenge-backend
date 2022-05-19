<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Enums\PetitionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePetitionRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;

class CreatePetitionController extends Controller
{
    public function __invoke(CreatePetitionRequest $request): JsonResponse
    {
        $petition = Petition::create([
            'title' => $request->get('title'),
            'symptoms' => $request->get('symptoms'),
            'patient_id' => $request->user()->patientInformation->id,
            'doctor_id' => null,
            'status' => PetitionStatus::PENDING->value,
        ]);

        return response()->json([$petition]);
    }
}
