<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('courses')->insert([
            ['name' => 'Développement Web'],
            ['name' => 'Marketing'],
            ['name' => 'Design UX/UI'],
        ]);
    }
}
