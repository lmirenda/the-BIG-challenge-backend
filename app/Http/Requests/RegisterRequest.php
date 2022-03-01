<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
            ],
            'email' => [
                'required',
                'unique:users',
                'email',
            ],
            'password' => [
                'required',
                Password::default(),
            ],
            'confirmed_password' => [
                'required',
                'same:password',
            ],
            'type' => [
                'required',
                new Enum(UserType::class), ],
        ];
    }
}
