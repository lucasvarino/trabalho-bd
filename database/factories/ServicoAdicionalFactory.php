<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServicoAdicional>
 */
class ServicoAdicionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nome" => $this->faker->word(),
            "preco" => $this->faker->randomFloat(2, 0, 1000),
            "descricao" => $this->faker->text(),
        ];
    }
}
