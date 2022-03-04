<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorAcceptPetitionController
{
    public function update(Petition $petition): JsonResponse
    {
        if ($petition->status === PetitionStatus::PENDING->value) {
            $petition->update([
                'status' => PetitionStatus::TAKEN->value,
                'doctor_id' => Auth::user()->id,
            ]);

            return response()->json([$petition]);
        }

        return response()->json(['Error'], 422);
    }
}
