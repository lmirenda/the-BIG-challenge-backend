<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorAcceptedPetitionsIndex extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([Petition::where('doctor_id', Auth::user()->id)]);
    }
}
