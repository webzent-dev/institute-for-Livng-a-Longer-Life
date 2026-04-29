<?php

namespace Database\Seeders;
use App\Models\Stat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stat::insert([
            ['number' => '10,000+', 'label' => 'Active Members'],
            ['number' => '4.9/5', 'label' => 'Average Rating'],
            ['number' => '95%', 'label' => 'Satisfaction Rate'],
            ['number' => '89%', 'label' => 'Report Better Health'],
        ]);
    }
}
