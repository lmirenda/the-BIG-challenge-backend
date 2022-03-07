<?php

namespace App\Http\Requests;

use App\Enums\PetitionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FinishPetitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $petition = $this->route('petition');
        if (
            $petition->status === PetitionStatus::TAKEN->value
            && $petition->doctor_id == Auth::user()->id
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
