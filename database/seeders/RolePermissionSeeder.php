<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate pivot tables to avoid duplicate entries (Optional)
        // DB::table('model_has_roles')->truncate();
        // DB::table('role_has_permissions')->truncate();
        // DB::table('roles')->truncate();
        // DB::table('permissions')->truncate();

        // Define roles
        $roles = ['admin', 'manager', 'employee'];

        // Define permissions from your database
        $permissions = [
            'user_request_view',
            'edit_leave_request',
            'delete_leave_request',
            'leave_request_status',
            'roles_and_permission',
            'user_view',
            'dashboard',
        ];

        // Seed permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Seed roles and assign permissions
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            // Assign all permissions to admin
            if ($roleName === 'admin') {
                $role->syncPermissions($permissions);
            }

            // Assign specific permissions to manager
            if ($roleName === 'manager') {
                $role->syncPermissions([
                    'user_view',
                    'user_request_view',
                    'edit_leave_request',
                    'leave_request_status',
                    'dashboard',
                ]);
            }

            // Assign limited permissions to a regular user
            if ($roleName === 'user') {
                $role->syncPermissions([
                    'user_request_view',
                    'dashboard',
                ]);
            }
        }

        // Assign roles to specific users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
            ]
        );
        $adminUser->assignRole('admin');

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password123'),
                'role' => 'manager'
            ]
        );
        $managerUser->assignRole('manager');

        $normalUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password123'),
                'role' => 'employee'
            ]
        );
        $normalUser->assignRole('user');

        echo "Roles and permissions seeded successfully! 🚀\n";
    }
}
