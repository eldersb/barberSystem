<?php

namespace Database\Seeders;

use App\Models\Scheduling;
use Illuminate\Database\Seeder;

class SchedulingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Scheduling::factory(5)->create();

    }
}
