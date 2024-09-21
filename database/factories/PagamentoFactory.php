<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pagamento>
 */
class PagamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "valor" => $this->faker->randomFloat(2, 0, 1000),
            "datapagamento" => $this->faker->date(),
            "metodopagamento" => $this->faker->randomElement(["Dinheiro", "Cartão de Crédito", "Cartão de Débito", "PIX", "Boleto"]),
        ];
    }
}
