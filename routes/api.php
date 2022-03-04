<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Petitions\Doctor\DoctorAcceptPetitionController;
use App\Http\Controllers\Petitions\Doctor\DoctorPendingPetitionsIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::middleware(['role:doctor'])
    ->get('/petitions', [DoctorPendingPetitionsIndex::class, 'index']);
Route::middleware(['role:doctor'])
    ->put('petitions/accept/{petition}', [DoctorAcceptPetitionController::class, 'update']);
