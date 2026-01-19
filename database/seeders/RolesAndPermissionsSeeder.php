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
        Permission::firstOrCreate(['name' => 'view own repairs']);

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage clients',
            'manage cars',
            'manage repairs',
            'view own repairs'
        ]);

        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $clientRole->givePermissionTo(['view own repairs']);

        // Assign admin role to first user (if exists)
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasRole('admin')) {
            $firstUser->assignRole('admin');
        }
    }
}
