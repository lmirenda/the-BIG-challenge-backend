<?php

namespace App\Http\Controllers\Petitions;

use App\Http\Controllers\Controller;
use App\Http\Requests\ViewPetitionRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ViewPetitionController extends Controller
{
    public function __invoke(ViewPetitionRequest $request, Petition $petition): JsonResponse
    {
        $petitionWithUser = $petition->load('patient.user');

        return response()->json($petitionWithUser);
    }
}
