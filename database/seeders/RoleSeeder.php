<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create([ 'name' => 'Admin' ]);
        $role2 = Role::create([ 'name' => 'Customer' ]);

        Permission::create([ 'name' => 'admin.dashboard']) -> syncRoles([$role1]);
        Permission::create([ 'name' => 'admin.events.index']) -> syncRoles([$role1]);
        Permission::create([ 'name' => 'admin.events.show']) -> syncRoles([$role1]);
        Permission::create([ 'name' => 'admin.events.edit']) -> syncRoles([$role1]);
        Permission::create([ 'name' => 'admin.events.tickets']) -> syncRoles([$role1]);
        Permission::create([ 'name' => 'admin.categories']) -> syncRoles([$role1]);
        Permission::create([ 'name' => 'admin.users']) -> syncRoles([$role1]);

        Permission::create([ 'name' => 'panel.events.index']) -> syncRoles([$role1, $role2]);
        Permission::create([ 'name' => 'panel.event.create']) -> syncRoles([$role1, $role2]);
        Permission::create([ 'name' => 'panel.event.show']) -> syncRoles([$role1, $role2]);
        Permission::create([ 'name' => 'panel.event.edit']) -> syncRoles([$role1, $role2]);
        Permission::create([ 'name' => 'panel.event.tickets']) -> syncRoles([$role1, $role2]);
        Permission::create([ 'name' => 'panel.event.form']) -> syncRoles([$role1, $role2]);
        Permission::create([ 'name' => 'panel.event.participants']) -> syncRoles([$role1, $role2]);
    }
}
