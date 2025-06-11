<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gass;

class GassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gasses = [
            [
                'name' => 'General Services and Support Services',
                'budget' => '0',
            ],
        ];

        foreach($gasses as $gass) {
            Gass::create($gass);
        }
    }
}
