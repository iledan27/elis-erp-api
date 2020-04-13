<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AddsRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roleSuperAdmin = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $roleUser = Role::create(['name' => 'user', 'guard_name' => 'api']);

        App\User::where('name', 'super admin')->first()->assignRole($roleSuperAdmin);
        App\User::where('name', 'admin')->first()->assignRole($roleAdmin);
        App\User::where('name', 'user')->first()->assignRole($roleUser);
    }
}
