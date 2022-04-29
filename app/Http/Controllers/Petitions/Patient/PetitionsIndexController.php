<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PetitionsIndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([$request->user()->patientInformation->petitions]);
    }
}
