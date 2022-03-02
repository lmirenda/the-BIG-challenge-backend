<?php

namespace Tests\Feature;

use App\Enums\UserType;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_factory_states_for_patient()
    {
        $rolePatient = Role::create(['name' => UserType::PATIENT]);
        $patient = Patient::factory()->create();
        $this->assertDatabaseHas('patients', ['id' => $patient['id']]);
    }
}
