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

        $states = collect(config('constants')['states'])
            ->keys();

        return [
            "first_name" => $this->faker->firstName(),
            "last_name" => $this->faker->lastName(),
            "gender" => $this->faker->randomElement(['Masculino', 'Feminino', 'Outros']),
            "telephone" => $this->faker->numerify('###########'),
            "document" => $this->faker->regexify('[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}'),
            "email" => $this->faker->email(),
            'street_name' => fake()->streetName(),
            'street_number' => random_int(1, 999),
            'state' => fake()->randomElement($states),
            'city' => fake()->city,
            'neighborhood' => fake()->city,
            "cep" => $this->faker->numerify('########'),
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = '2005-12-31'), // Até 2005
        ];
    }
}
