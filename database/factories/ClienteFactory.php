<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nome" => $this->faker->name(),
            "contato" => $this->faker->email(),
            "identidade" => $this->faker->regexify('[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}'),
        ];
    }
}
