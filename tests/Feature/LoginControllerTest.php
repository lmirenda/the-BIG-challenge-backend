<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_user_can_log_in()
    {
        $user = User::factory()->create(['password'=>Hash::make(123456)]);
        $response = $this->postJson('api/login',['email' => $user->email, 'password'=>123456]);
        $response->assertSuccessful();
    }

    public function test_invalid_password()
    {
        $user = User::factory()->create();
        $response = $this->postJson('api/login',['email' => $user->email, 'password'=>123456]);
        $response->assertUnprocessable();
    }
}
