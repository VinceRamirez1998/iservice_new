<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin user
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'), // Set a default password
            'role'=>'admin',
        ]);

        $provider = User::factory()->create([
            'name' => 'provider',
            'email' => 'provider@gmail.com',
            'password' => bcrypt('provider'), // Set a default password
            'role'=>'2',
        ]);

        $customer = User::factory()->create([
            'name' => 'hehe',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('customer'), // Set a default password
            'role'=>'3',
        ]);

        // Define roles
        $roles = [
            'admin',
            'provider',
            'customer',
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => trim($role), 'guard_name' => 'web']);
        }

        // Assign the 'admin' role to the default user
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $user->assignRole($adminRole);
        }

        // Define permissions
        $permissions = [
            'View Role',
            'Create Role',
            'Update Role',
            'Delete Role',
            'CRUD Role',
            'Create Permission',
            'View Permission',
            'Update Permission',
            'Delete Permission',
            'CRUD Permission',
            'Create Service',
            'View Service',
            'Update Service',
            'Delete Service',
            'CRUD Service',
            'Create User',
            'View User',
            'Update User',
            'Delete User',
            'CRUD User',
            'Create Billing',
            'View Billing',
            'Update Billing',
            'Delete Billing',
            'CRUD Billing',
            'Create Subscription',
            'View Subscription',
            'Update Subscription',
            'Delete Subscription',
            'CRUD Subscription',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => trim($permission), 'guard_name' => 'web']);
        }

        // Define services
        $services = [
            'N/A',
            'Appliances Services',
            'Electrical Services',
            'Plumbing Services',
            'Mechanic Services',
        ];

        // Create services
        foreach ($services as $service) {
            Service::firstOrCreate(['name' => trim($service)]);
        }
    }
}
