<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AluguelCarro>
 */
class AluguelCarroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data_inicio = $this->faker->date();
        $data_fim = $this->faker->dateTimeBetween($data_inicio, '+1 year')->format('Y-m-d');
        return [
            "dataInicio" => $data_inicio,
            "dataFim" => $data_fim,
            "placa" => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];
    }
}
