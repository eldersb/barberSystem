<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory(5)->create();

        $categories = [
            ['name' => 'Corte máquina', 'price' => 20], 
            ['name' => 'Corte navalhado', 'price' => 25], 
            ['name' => 'Corte tesoura', 'price' => 25],
            ['name' => 'Barba', 'price' => 10],
            ['name' => 'Sobrancelha', 'price' => 5],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}   



