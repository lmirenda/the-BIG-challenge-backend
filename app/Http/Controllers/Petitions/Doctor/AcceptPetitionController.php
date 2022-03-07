<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Http\Requests\AcceptPendingPetitionsRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AcceptPetitionController
{
    public function __invoke(Petition $petition, AcceptPendingPetitionsRequest $request): JsonResponse
    {
        $petition->update([
                'status' => PetitionStatus::TAKEN->value,
                'doctor_id' => Auth::user()->id,
            ]);

        return response()->json([$petition]);
    }
}
