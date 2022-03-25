<?php

namespace App\Http\Controllers\Petitions\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class CreatePatientController extends Controller
{
    public function __invoke(CreatePatientRequest $request): PatientResource
    {
        $patient = Patient::create([
            'user_id' => $request->user()->id,
            'patient_height' => $request->get('patient_height'),
            'patient_weight' => $request->get('patient_weight'),
            'patient_phone' => $request->get('patient_phone'),
            'patient_other_info' => $request->get('patient_other_info'),
        ]);

        return new PatientResource($patient);
    }
}
