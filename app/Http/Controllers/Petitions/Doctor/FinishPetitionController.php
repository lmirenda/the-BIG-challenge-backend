<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Events\DoctorHasResponded;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinishPetitionRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;

class FinishPetitionController extends Controller
{
    public function __invoke(Petition $petition, FinishPetitionRequest $request): JsonResponse
    {
        $petition->update([
            'status' => PetitionStatus::FINISHED->value,
        ]);
        $user = $petition->patient->user;

        event(new DoctorHasResponded($user));

        return response()->json([$petition]);
    }
}
