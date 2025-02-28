<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Subject::create([
            'name' => 'Algèbre',
        ]);
        Subject::create([
            'name' => 'Calcul intégral',
        ]);
        Subject::create([
            'name' => 'Chimie',
        ]);
        Subject::create([
            'name' => 'Programmation web',
        ]);
    }
}
