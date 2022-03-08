<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePetitionRequest extends FormRequest
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
            'title' => ['required', 'min:3'],
            'symptoms' => ['required', 'min:10'],
        ];
    }
}
