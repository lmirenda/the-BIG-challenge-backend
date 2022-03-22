<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\LogoutController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test__logged_user_can_log_out()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this
            ->postJson('api/logout')
            ->assertSuccessful();
    }
}
