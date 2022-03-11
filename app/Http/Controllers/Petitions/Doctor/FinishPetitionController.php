<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Events\DoctorHasResponded;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinishPetitionRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class FinishPetitionController extends Controller
{
    public function __invoke(Petition $petition, FinishPetitionRequest $request): JsonResponse
    {
        if ($request->hasFile('file')) {
            $fileName = Str::uuid().'.txt';
            $request
                ->file('file')
                ->storeAs('public/petition_files', $fileName);

            $petition->update([
                'status' => PetitionStatus::FINISHED->value,
                'file' => $fileName,
            ]);
            $user = $petition->patient->user;

            event(new DoctorHasResponded($user));

            return response()->json([$petition]);
        }

        return response()->json(['error']);
    }
}
