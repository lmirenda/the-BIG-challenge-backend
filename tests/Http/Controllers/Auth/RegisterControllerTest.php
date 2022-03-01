<?php

namespace Tests\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Events\UserHasRegistered;
use App\Mail\RegisterNewUserMail;
use App\Models\User;
use App\Utilities\Random;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
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

    public function test_successful_registration_dispatches_event()
    {

        Event::fake();
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@doe.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];

        $this
            ->postJson('api/register', $userData);

        Event::assertDispatched(UserHasRegistered::class);
    }

    public function test_successful_registration_sends_one_email()
    {
        Mail::fake();
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@doe.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];

        $this
            ->postJson('api/register', $userData);

        Mail::assertSent(RegisterNewUserMail::class);
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

    public function test_new_user_cant_register_with_unknown_type()
    {
        $userData = [
            'name' => 'John Doe',
            'email'=>'test@email.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => 'other'
        ];
        $this
            ->postJson('api/register', $userData)
            ->assertUnprocessable();
    }

    public function test_new_user_cant_register_with_short_name()
    {
        $userData = [
            'name' => 'Do',
            'email'=>'test@email.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];
        $this
            ->postJson('api/register', $userData)
            ->assertUnprocessable();
    }

    public function test_new_user_cant_register_with_empty_fields()
    {
        $noName = [
            'email'=>'test@email.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];
        $noEmail = [
            'name' => 'John Doe',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];
        $noPassword = [
            'name' => 'John Doe',
            'email'=>'test@email.io',
            'confirmed_password' => 'Password01',
            'type' => Random::userType()
        ];
        $noConfirmation = [
            'name' => 'John Doe',
            'email'=>'test@email.io',
            'password' => 'Password01',
            'type' => Random::userType()
        ];
        $noType = [
            'name' => 'John Doe',
            'email'=>'test@email.io',
            'password' => 'Password01',
            'confirmed_password' => 'Password01',
        ];

        $this
            ->postJson('api/register', $noName)
            ->assertUnprocessable();
        $this
            ->postJson('api/register', $noEmail)
            ->assertUnprocessable();
        $this
            ->postJson('api/register', $noPassword)
            ->assertUnprocessable();
        $this
            ->postJson('api/register', $noConfirmation)
            ->assertUnprocessable();
        $this
            ->postJson('api/register', $noType)
            ->assertUnprocessable();
    }

    public function test_failed_registration_does_not_dispatch_event()
    {
        Event::fake();
        $this
            ->postJson('api/register', []);
        Event::assertNotDispatched(UserHasRegistered::class);
    }

    public function test_failed_registration_does_not_send_email()
    {
        Mail::fake();
        $this
            ->postJson('api/register', []);
        Mail::assertNothingSent();
    }
}
