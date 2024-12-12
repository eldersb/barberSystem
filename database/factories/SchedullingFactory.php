<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedulling>
 */
class SchedullingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "barber_id" => $this->faker->numberBetween(1, 5),
            "client_id" => $this->faker->numberBetween(1, 5),
            "category_id" => $this->faker->numberBetween(1, 5),
            "serviceTime" => $this->faker->dateTimeBetween('now', '+1 week')->format('Y-m-d H:i'),
            "serviceValue" => number_format($this->faker->randomFloat(2, 10, 100), 2, '.', ''),
            "payment" => $this->faker->randomElement(['Cartão', 'Pix', 'Dinheiro']),
            "status" => $this->faker->randomElement(['Em andamento', 'Finalizado'])
        ];
    }
}
