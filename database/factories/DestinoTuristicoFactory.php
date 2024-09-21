<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DestinoTuristico>
 */
class DestinoTuristicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $destinos = [
            "Igreja da Sagrada Família, Barcelona (Espanha)",
            "Coliseu, Roma (Itália) ",
            "Casa de Anne Frank, Amsterdã (Holanda) ",
            "Fontes de Dubai, Dubai (Emirados Árabes) ",
            "Empire State Building, Nova York (Estados Unidos)",
            "Musée d'Orsay, Paris (França) ",
            "Torre Eiffel, Paris (França) ",
            "Fontana di Trevi, Roma (Itália) ",
            "Central Park, Nova York (Estados Unidos)",
            "Praça de Espanha, Sevilha (Espanha) ",
            "Catedral de Milão (Itália) ",
            "Parque del Retiro, Madri (Espanha) ",
            "Kilmainham Gaol, Dublin (Irlanda) ",
            "Acrópole, Atenas (Grécia) ",
            "Grande Mesquita Sheikh Zayed, Abu Dhabi (Emirados Árabes) ",
            "Angkor Wat, Siem Reap (Camboja) ",
            "Gardens by the Bay, Singapura (Cingapura) ",
            "Iolani Palace, Honolulu (Havaí) ",
            "Jardim Majorelle, Marraquexe (Marrocos) ",
            "Museu Nacional de Antropologia, Cidade do México (México) ",
            "Stanley Park, Vancouver (Canadá)",
            "Taj Mahal, Agra (Índia) ",
            "Petra, Wadi Musa (Jordânia) ",
            "Les 7 Cascades, Maurício (África)",
            "Pirâmides de Gizé, Cairo (Egito)",
            "Cristo Redentor, Rio de Janeiro ",
            "Bondinho Pão de Açúcar, Rio de Janeiro ",
            "Cataratas do Iguaçu, Foz do Iguaçu ",
            "Parque Ibirapuera, São Paulo",
            "Lago Negro, Gramado",
        ];

        return [
            "nome" => $destinos[array_rand($destinos)],
            "descricao" => $this->faker->text(),
            "localizacao" => $this->faker->city(),
        ];
    }
}
