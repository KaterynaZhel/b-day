<?php

namespace Database\Seeders;

use App\Models\Greeting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GreetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Greeting::factory()->count(60)->create();
    }
}