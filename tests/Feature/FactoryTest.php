<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_factory_states_for_patient_and_doctor()
    {
        $patient = Patient::factory()
           ->for(User::factory()->state([
               'name' => 'Test Patient',
           ]))
           ->create();
        $this->assertModelExists($patient);
    }
}
