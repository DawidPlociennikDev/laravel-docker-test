<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Place::create([
            'name' => 'Poland',
            'visited' => random_int(0,1),
            'visited_by' => 'Dawid',
        ]);

        Place::factory()->count(10)->create();

    }
}
