<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::firstOrCreate(['name' => 'manage clients']);
        Permission::firstOrCreate(['name' => 'manage cars']);
        Permission::firstOrCreate(['name' => 'manage repairs']);
        Permission::firstOrCreate(['name' => 'manage admins']);
        Permission::firstOrCreate(['name' => 'view own repairs']);

        // Create Super Admin role (system owner - first user)
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo([
            'manage clients',
            'manage cars',
            'manage repairs',
            'manage admins',
            'view own repairs'
        ]);

        // Create Admin role (can manage clients, cars, repairs but NOT other admins)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage clients',
            'manage cars',
            'manage repairs',
            'view own repairs'
        ]);

        // Create Client role
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $clientRole->givePermissionTo(['view own repairs']);

        // Assign super-admin role to first user (system owner)
        $firstUser = User::first();
        if ($firstUser) {
            // Remove any existing roles and assign super-admin
            $firstUser->syncRoles(['super-admin']);
        }
    }
}
