<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorAcceptPetitionController
{
    public function update(Petition $petition): JsonResponse
    {
        if (Auth::user()->hasRole(UserType::DOCTOR->value) && $petition->status === PetitionStatus::PENDING->value) {
            $petition->update([
                'status' => PetitionStatus::TAKEN->value,
                'doctor_id' => Auth::user()->id,
            ]);

            return response()->json([$petition]);
        }

        return response()->json(['Error'], 422);
    }
}
