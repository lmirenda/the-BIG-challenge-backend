<?php

namespace Tests\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_user_can_be_registered()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@doe.io',
            'password' => 'Password01',
            'type' => UserType::PATIENT
        ];

        $response = $this->postJson('api/register', $userData);
        $response ->dd()
            ->assertSuccessful()
            ->assertJson([
                'created' => true,
            ]);
    }


}
