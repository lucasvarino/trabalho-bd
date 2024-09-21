<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voo>
 */
class VooFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "horarioPartida" => $this->faker->time("H:i"),
            "horarioChegada" => $this->faker->time("H:i"),
        ];
    }
}