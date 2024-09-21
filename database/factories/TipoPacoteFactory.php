<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoPacote>
 */
class TipoPacoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tematica = $this->faker->randomElement(["Romantico", "Familia", "Aventura", "Luxo"]);
        return [
            "nome" => $this->faker->word() . ' - ' . $tematica,
            "tematica" => $tematica,
            "duracao" => $this->faker->random_int(1, 30),
        ];
    }
}
