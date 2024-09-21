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
        $data_inicio = $this->faker->dateTimeBetween("now", '+1 year')->format('Y-m-d');
        $data_fim = $this->faker->dateTimeBetween($data_inicio . " +1 day", $data_inicio . ' +1 year')->format('Y-m-d');

        return [
            "datainicio" => $data_inicio,
            "datafim" => $data_fim,
            "placa" => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];
    }
}
