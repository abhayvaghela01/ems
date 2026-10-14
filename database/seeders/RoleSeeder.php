<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $hrRole = Role::firstOrCreate(['name' => 'hr']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);

        $adminUser = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' =>  'admin@2216'
        ])->assignRole($adminRole);

        // $adminUser->role()->associate($adminRole);
        // $adminUser->save();

        // Permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage todos',
            'manage notes',
            'manage payslips',
            'manage expenses',
            'view own payslip'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assigning permissions
        $adminRole->syncPermissions(Permission::all());
        $hrRole->syncPermissions(['manage users', 'manage todos', 'manage notes', 'manage payslips', 'manage expenses']);
        $memberRole->syncPermissions(['manage todos', 'manage notes', 'view own payslip']);
    }
}
