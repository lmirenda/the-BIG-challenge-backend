<?php

namespace App\Http\Requests;

use App\Enums\PetitionStatus;
use App\Models\Petition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DownloadPetitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Petition $petition */
        $petition = $this->route('petition');

        return $petition->status === PetitionStatus::FINISHED->value &&
            $petition->patient->user->id === Auth::user()->id;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
