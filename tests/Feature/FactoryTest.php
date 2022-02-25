<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use test_factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function test_the_user_factory_states_for_patient_and_doctor()
    {
       $patient = Patient::factory()
           ->for(User::factory()->state([
               'name' => "Test Patient"
           ]))
           ->create();
    }
}
