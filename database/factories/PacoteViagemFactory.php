<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PacoteViagem>
 */
class PacoteViagemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data_de_partida = $this->faker->dateTimeBetween('now + 1 day', '+1 year')->format('Y-m-d');
        $data_de_retorno = $this->faker->dateTimeBetween($data_de_partida . '+ 1 day', $data_de_partida . ' +1 week')->format('Y-m-d');

        return [
            "destino" => $this->faker->city(),
            "datadepartida" => $data_de_partida,
            "dataderetorno" => $data_de_retorno,
            "preco" => $this->faker->randomFloat(2, 4500, 100000),
            "capacidademaxima" => $this->faker->numberBetween(1, 30),
        ];
    }
}
