<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Note::factory(30)->create();
        // \App\Models\Todo::factory(10)->create();


        // $this->call([
        //     RoleSeeder::class, // runs first
        //     AdminSeeder::class,
        // ]);

        // User::factory()->create([
        //     'name' => 'abhay',
        //     'email' => 'abhay@gmail.com',
        //     'password' => '123456'
        // ]);
        // Note::factory()->create([
        //     [
        //         'title' => 'notes',
        //         'description' => 'my fisrt note',
        //         'color' => 'green',
        //         'user_id' => '2'
        //     ],
        //     [
        //         'title' => 'todo',
        //         'description' => 'my second note',
        //         'color' => 'red',
        //         'user_id' => '2'
        //     ],
        // ]);
    }
}
