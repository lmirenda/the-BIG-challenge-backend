<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Petitions\Doctor\AcceptPetitionController;
use App\Http\Controllers\Petitions\Doctor\DoctorAcceptedPetitionsIndex;
use App\Http\Controllers\Petitions\Doctor\DoctorFinishedPetitionsIndex;
use App\Http\Controllers\Petitions\Doctor\FinishPetitionController;
use App\Http\Controllers\Petitions\Doctor\PatientsIndex;
use App\Http\Controllers\Petitions\Doctor\PendingPetitionsIndex;
use App\Http\Controllers\Petitions\Patient\CreatePatientController;
use App\Http\Controllers\Petitions\Patient\CreatePetitionController;
use App\Http\Controllers\Petitions\Patient\DownloadPetitionController;
use App\Http\Controllers\Petitions\Patient\PetitionsIndexController;
use App\Http\Controllers\Petitions\ViewPetitionController;
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
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->get('/petitions', PendingPetitionsIndex::class);
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->get('/patients', PatientsIndex::class);
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->get('/petitions/finished', DoctorFinishedPetitionsIndex::class);
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->get('/petitions/accepted', DoctorAcceptedPetitionsIndex::class);
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->put('petitions/accept/{petition}', AcceptPetitionController::class);
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->put('petitions/accepted/finish/{petition}', FinishPetitionController::class);
Route::middleware(['auth:sanctum', 'role:patient'])
    ->get('/my/petitions', PetitionsIndexController::class);
Route::middleware(['role:patient', 'auth:sanctum'])
    ->post('/petitions/create', CreatePetitionController::class);
Route::middleware(['auth:sanctum', 'role:patient'])
    ->get('petitions/download/{petition}', DownloadPetitionController::class);
Route::middleware('auth:sanctum')->post('/logout', LogoutController::class);
Route::middleware(['role:patient', 'auth:sanctum'])
    ->post('/patient/create', CreatePatientController::class);
Route::middleware(['role:doctor', 'auth:sanctum'])
    ->get('/petitions/{petition}', ViewPetitionController::class);
