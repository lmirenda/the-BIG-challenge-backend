<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetitionsIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = User::with('patientInformation.petitions')
            ->where('id', Auth::user()->id)
            ->first();


        return response()->json($user->petitions);
    }
}
