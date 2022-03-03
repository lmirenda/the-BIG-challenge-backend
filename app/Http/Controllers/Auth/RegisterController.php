<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserHasRegistered;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'type' => $request->get('type'),
        ]);
        $user->assignRole($request->get('type'));

        event(new UserHasRegistered($user));

        return response()->json([$user]);
    }
}
