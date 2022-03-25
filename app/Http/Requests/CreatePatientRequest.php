<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(UserType::PATIENT->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patient_height' => ['required', 'min:1'],
            'patient_weight' => ['required', 'min:1'],
            'patient_phone' => ['required', 'min:1'],
            'patient_other_info' => ['required', 'max:255'],
        ];
    }
}
