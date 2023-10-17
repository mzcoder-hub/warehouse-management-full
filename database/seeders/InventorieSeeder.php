<?php

namespace Database\Seeders;

use App\Models\Inventorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventorie::factory(50)->create();
    }
}
