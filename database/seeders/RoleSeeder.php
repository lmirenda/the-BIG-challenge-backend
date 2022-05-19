<?php

namespace Database\Seeders;

use App\Enums\UserType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleDoctor = Role::create(['name' => UserType::DOCTOR->value]);
        $rolePatient = Role::create(['name' => UserType::PATIENT->value]);
    }
}
