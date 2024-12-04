<?php

namespace Database\Seeders;

use App\Models\Schedulling;
use Illuminate\Database\Seeder;

class SchedullingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedulling::factory(3)->create();

    }
}
