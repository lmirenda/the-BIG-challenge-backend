<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorPendingPetitionsIndex extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([Petition::where('status', PetitionStatus::PENDING->value)]);
    }
}
