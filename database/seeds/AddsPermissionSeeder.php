<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'see-products', 'guard_name' => 'api']);

        $role1 = Role::where('name', 'admin')->first();
        $role1->givePermissionTo('see-products');

        Permission::create(['name' => 'see-tasks', 'guard_name' => 'api']);

        $role2 = Role::where('name', 'user')->first();
        $role2->givePermissionTo('see-tasks');
    }
}
