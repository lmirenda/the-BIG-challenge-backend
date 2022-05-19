<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Http\Controllers\Controller;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorFinishedPetitionsIndex extends Controller
{
    public function __invoke(): JsonResponse
    {
        $petition = Petition::where('doctor_id', Auth::user()->id)
            ->where('status', PetitionStatus::FINISHED->value)
            ->with('patient.user')->paginate(10);

        return response()->json($petition);
    }
}
