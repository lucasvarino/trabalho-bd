<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Academia>
 */
class AcademiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "horariofuncionamento" => "Seg - Sex: {$this->faker->time()} - {$this->faker->time()}",
            "endereco" => $this->faker->address(),
        ];
    }
}
