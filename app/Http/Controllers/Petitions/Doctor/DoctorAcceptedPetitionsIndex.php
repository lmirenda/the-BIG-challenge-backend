<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorAcceptedPetitionsIndex extends Controller
{
    public function __invoke(): JsonResponse
    {
        $petition = Petition::where('doctor_id', Auth::user()->id)->paginate(10);

        return response()->json($petition);
===
    }
}
