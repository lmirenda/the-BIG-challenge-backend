<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Enums\PetitionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePetitionRequest;
use App\Models\Petition;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatePetitionController extends Controller
{
    public function __invoke(CreatePetitionRequest $request): JsonResponse
    {
        $user = User::with('patientInformation.petitions')
            ->where('id', Auth::user()->id)
            ->first();

        $petition = Petition::create([
            'title' => $request->get('title'),
            'symptoms' => $request->get('symptoms'),
            'patient_id' => $user->patientInformation->id,
            'doctor_id' => null,
            'status' => PetitionStatus::PENDING->value,
        ]);

        return response()->json([$petition]);
    }
}
