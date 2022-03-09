<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PatientsIndex extends Controller
{
    public function __invoke(Request $request)
    {
        $users = User::where('type', UserType::PATIENT->value)
            ->with('patientInformation.petitions')
            ->get();
        return response()->json($users);
    }
}
