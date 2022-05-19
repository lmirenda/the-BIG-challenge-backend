<?php

namespace App\Http\Controllers\Petitions\Doctor;

use App\Enums\PetitionStatus;
use App\Events\DoctorHasResponded;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinishPetitionRequest;
use App\Models\Petition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FinishPetitionController extends Controller
{
    public function __invoke(Petition $petition): JsonResponse
    {
//        $fileName = Str::uuid().'.txt';
//        $file = $request->file('file');

//        Storage::put($fileName, $file);

        $petition->update([
                'status' => PetitionStatus::FINISHED->value,
                'file' => Str::uuid().'.txt',
            ]);

        $user = $petition->patient->user;

        event(new DoctorHasResponded($user));

        return response()->json([$petition]);
    }
}
