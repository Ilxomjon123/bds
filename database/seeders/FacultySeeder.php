<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faculty::truncate();
        Faculty::insert([
            ['name' => 'Rektorat'],
            ['name' => 'Matmatika']
        ]);
    }
}
