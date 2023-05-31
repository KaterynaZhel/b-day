<?php

namespace Database\Seeders;

use App\Models\Celebrant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CelebrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Celebrant::factory()->count(20)->create();
    }
}
