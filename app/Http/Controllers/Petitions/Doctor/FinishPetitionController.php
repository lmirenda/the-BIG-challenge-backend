<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcceptPendingPetitionsRequest;
use App\Http\Requests\FinishPetitionRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FinishPetitionController extends Controller
{
    public function __invoke(Petition $petition, FinishPetitionRequest $request): JsonResponse
    {
        $petition->update([
            'status' => PetitionStatus::FINISHED->value,
        ]);

        return response()->json([$petition]);
    }
}
