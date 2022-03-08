<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetitionsIndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([$request->user()->petitions]);
    }
}
