<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BasicAdminPermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'permission_list',
            'permission_create',
            'permission_edit',
            'permission_delete',
            'role_list',
            'role_create',
            'role_edit',
            'role_delete',
            'user_list',
            'user_create',
            'user_edit',
            'user_delete',
            'post_list',
            'post_create',
            'post_edit',
            'post_delete',
            'invoice_create',
            'invoice_edit',
            'invoice_delete',
            'invoice_list',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'manager']);
        $role1->givePermissionTo('permission_list');
        $role1->givePermissionTo('role_list');
        $role1->givePermissionTo('user_list');
        $role1->givePermissionTo('post_list');
        $role1->givePermissionTo('post_create');
        $role1->givePermissionTo('post_edit');
        $role1->givePermissionTo('post_delete');
        $role1->givePermissionTo('invoice_create');
        $role1->givePermissionTo('invoice_list');

        $role2 = Role::create(['name' => 'admin']);
        foreach ($permissions as $permission) {
            $role2->givePermissionTo($permission);
        }

        $role3 = Role::create(['name' => 'superadmin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => \Hash::make('password'),
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Hash::make('password'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'password' => \Hash::make('password'),
        ]);
        $user->assignRole($role1);
    }
}
