<?php

namespace Tests\Http\Controllers\Auth;

use App\Models\User;
use App\Utilities\Random;
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
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];

        $this
            ->postJson('api/register', $userData)
            ->assertSuccessful();
    }

    public function test_new_user_cant_register_without_matching_passwords()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@doe.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password02',
            'type' => Random::userType()
        ];

        $this
            ->postJson('api/register', $userData)
            ->assertUnprocessable();
    }

    public function test_new_user_cant_register_with_used_email()
    {
        User::factory()->create(['email'=>'test@email.io']);
        $userData = [
            'name' => 'John Doe',
            'email'=>'test@email.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];

        $this
            ->postJson('api/register', $userData)
            ->assertUnprocessable();
    }

    public function test_new_user_cant_register_with_unkown_type()
    {
        $userData = [
            'name' => 'John Doe',
            'email'=>'test@email.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => 'other'
        ];
        $this->postJson('api/register', $userData)
            ->assertUnprocessable();
    }
}
