<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AvaliacaoCliente>
 */
class AvaliacaoClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nota" => $this->faker->numberBetween(0, 5),
            "comentario" => $this->faker->text(),
        ];
    }
}
