<?php

namespace App\Http\Requests;

use App\Enums\PetitionStatus;
use App\Enums\UserType;
use App\Models\Petition;
use Illuminate\Foundation\Http\FormRequest;

class ViewPetitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Petition $petition */
        $petition = $this->route('petition');
        return $this->isDoctor($petition) || $this->isPatient($petition);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function isDoctor(Petition $petition)
    {
        return $this->user()->hasRole(UserType::DOCTOR->value) &&
            ($this->user()->id == $petition->doctor_id || $petition->status == PetitionStatus::PENDING->value);
    }

    public function isPatient(Petition $petition)
    {
        return $this->user()->hasRole(UserType::PATIENT->value) && $this->user()->patientInformation->id == $petition->patient_id;
    }
}
