<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Organizational Development Division'
            ],[
                'name' => 'Appointments and Administrative Division'
            ],[
                'name' => 'Personnel Relations and Discipline Division'
            ],[
                'name' => 'Benefits and Welfare Division'
            ],
        ];

        foreach($divisions as $division) {
            Division::create($division);
        }
    }
}
