<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@admin',
                'level' => 'Amin',
                'password' => Hash::make('123456'),
                'faculty_id' => 1,
                'role_id' => 1
            ],
            [
                'name' => 'Test',
                'email' => 'test@test',
                'level' => 'Test',
                'password' => Hash::make('123456'),
                'faculty_id' => 2,
                'role_id' => 2
            ]
        ]);
    }
}
