<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Http\Controllers\Controller;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;

class PendingPetitionsIndex extends Controller
{
    public function __invoke(): JsonResponse
    {
        $petition = Petition::where('status', PetitionStatus::PENDING->value) ->with('patient.user')->paginate(10);

        return response()->json([$petition]);
    }
}
