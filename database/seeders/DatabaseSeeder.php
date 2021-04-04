<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            FacultySeeder::class,
            RoleSeeder::class,
            UserSeeder::class
        ]);

        \App\Models\ElectionType::factory(3)->create();
        \App\Models\Election::factory(10)->create();
    }
}
