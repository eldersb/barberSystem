<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "telephone" => $this->faker->phonenumber(),
            "address" => $this->faker->address(),
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = '2005-12-31'), // Até 2005
        ];
    }
}
