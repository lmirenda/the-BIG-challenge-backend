<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Petition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        User::factory()->create();
        User::factory()->patient()->create();
        User::factory()->doctor()->create();

        Patient::factory()->create();

        Petition::factory(5)->create();
    }
}
