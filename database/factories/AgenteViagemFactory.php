<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgenteViagem>
 */
class AgenteViagemFactory extends Factory
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
            "comissao" => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
