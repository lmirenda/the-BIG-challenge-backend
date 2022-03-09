<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Petitions\Doctor\AcceptPetitionController;
use App\Http\Controllers\Petitions\Doctor\DoctorAcceptedPetitionsIndex;
use App\Http\Controllers\Petitions\Doctor\FinishPetitionController;
use App\Http\Controllers\Petitions\Doctor\PatientsIndex;
use App\Http\Controllers\Petitions\Doctor\PendingPetitionsIndex;
use App\Http\Controllers\Petitions\Patient\CreatePetitionController;
use App\Http\Controllers\Petitions\Patient\PetitionsIndexController;
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
    ->get('/petitions', PendingPetitionsIndex::class);
Route::middleware(['role:doctor'])
    ->get('/patients', PatientsIndex::class);
Route::middleware(['role:doctor'])
    ->get('/petitions/accepted', DoctorAcceptedPetitionsIndex::class);
Route::middleware(['role:doctor'])
    ->put('petitions/accept/{petition}', AcceptPetitionController::class);
Route::middleware(['role:doctor'])
    ->put('petitions/accepted/finish/{petition}', FinishPetitionController::class);
Route::middleware(['role:patient'])
    ->get('/my/petitions', PetitionsIndexController::class);
Route::middleware(['role:patient'])
    ->post('/petitions/create', CreatePetitionController::class);
