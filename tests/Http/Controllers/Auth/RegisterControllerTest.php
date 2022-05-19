<?php

namespace Tests\Http\Controllers\Auth;

use App\Events\UserHasRegistered;
use App\Mail\RegisterNewUserMail;
use App\Models\User;
use App\Utilities\Random;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider  validUserDataProvider
     */
    public function test_new_user_can_be_registered($userData)
    {
        Event::fake();
        $this
            ->seed(RoleSeeder::class)
            ->postJson('api/register', $userData)
            ->assertSuccessful();
        Event::assertDispatched(UserHasRegistered::class);
    }

    /**
     * @dataProvider  validUserDataProvider
     */
    public function test_successful_registration_sends_one_email($userData)
    {
        Mail::fake();
        $this
            ->seed(RoleSeeder::class)
            ->postJson('api/register', $userData);

        Mail::assertQueued(RegisterNewUserMail::class, 1);
    }

    /**
     * @dataProvider  invalidUserDataProvider
     */
    public function test_new_user_cant_register_with_invalid_data($user)
    {
        User::factory()->create(['email'=>'repeated@email.io']);
        Event::fake();
        Mail::fake();
        $this
            ->postJson('api/register', $user)
            ->assertUnprocessable();
        Event::assertNotDispatched(UserHasRegistered::class);
        Mail::assertNothingSent();
    }

    public function validUserDataProvider(): array
    {
        return [
            ['User data' => [
                    'name' => 'John Doe',
                    'email' => 'john@doe.io',
                    'password' => 'Password01',
                    'confirmed_password' => 'Password01',
                    'type' => Random::userType(),
            ]],
        ];
    }

    public function invalidUserDataProvider() :array
    {
        return [
            ['no Name' => [
                'email'=>'test@email.io',
                'password' => 'Password01',
                'confirmed_password' => 'Password01',
                'type' => Random::userType(),
            ]],
            ['no Email' => [
                'name' => 'John Doe',
                'password' => 'Password01',
                'confirmed_password' => 'Password01',
                'type' => Random::userType(),
            ]],
            ['no Password' => [
                'name' => 'John Doe',
                'email'=>'test@email.io',
                'confirmed_password' => 'Password01',
                'type' => Random::userType(),
            ]],
            ['no Confirmation' => [
                'name' => 'John Doe',
                'email'=>'test@email.io',
                'password' => 'Password01',
                'type' => Random::userType(),
            ]],
            ['no Type' => [
                'name' => 'John Doe',
                'email'=>'test@email.io',
                'password' => 'Password01',
                'confirmed_password' => 'Password01',
            ]],
            ['other Type' => [
                'name' => 'John Doe',
                'email'=>'test@email.io',
                'password' => 'Password01',
                'confirmed_password' => 'Password01',
                'type' => 'other',
            ]],
            ['short Name' => [
                'name' => 'Do',
                'email'=>'test@email.io',
                'password' => 'Password01',
                'confirmed_password' => 'Password01',
                'type' => Random::userType(),
            ]],
            ['wrong Confirmation' => [
                'name' => 'Do',
                'email'=>'test@email.io',
                'password' => 'Password01',
                'confirmed_password' => 'Password02',
                'type' => Random::userType(),
            ]],
            ['repeated email' => [
                'name' => 'Do',
                'email'=>'repeated@email.io',
                'password' => 'Password01',
                'confirmed_password' => 'Password02',
                'type' => Random::userType(),
            ]],
        ];
    }
}
