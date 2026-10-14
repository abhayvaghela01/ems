<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin role if it doesn't exist
        // $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // // Check if the admin already exits 
        // $admin = User::where('email', 'admin@gmail.com')->first();

        // if (!$admin) {

        //     // Create admin
        //     $admin = User::create([
        //         'name' => 'Admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => 'admin@2216'

        //     ]);

        //     // Assign the admin role
        //     $admin->assignRole($adminRole);

        //     echo 'Admin user created successfuly.';
        // } else {
        //     echo 'Admin user already exists';
        // }
    }
}
